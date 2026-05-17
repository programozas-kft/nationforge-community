<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DripCampaign;
use App\Models\DripEnrollment;
use App\Models\DripStep;
use App\Models\Group;
use App\Models\Person;
use App\Models\Tag;
use App\Services\WebhookService;
use Illuminate\Http\Request;

class DripCampaignController extends Controller
{
    // ── Drip campaigns ──────────────────────────────────────────────────────────

    public function index()
    {
        $campaigns = DripCampaign::withCount(['steps', 'enrollments',
            'enrollments as active_count' => fn ($q) => $q->where('status', 'active'),
        ])->latest()->get();

        $groups = Group::orderBy('name')->get(['id', 'name']);
        $tags   = Tag::orderBy('name')->get(['id', 'name']);

        return view('admin.drip_campaigns.index', compact('campaigns', 'groups', 'tags'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:200',
            'description'      => 'nullable|string|max:400',
            'trigger_type'     => 'required|in:manual,group_join,tag_added',
            'trigger_group_id' => 'nullable|exists:groups,id',
            'trigger_tag_id'   => 'nullable|exists:tags,id',
        ]);

        $data['created_by'] = auth()->id();

        DripCampaign::create($data);

        return back()->with('success', __('drip.created'));
    }

    public function show(DripCampaign $dripCampaign)
    {
        $dripCampaign->load(['steps', 'triggerGroup', 'triggerTag']);

        $enrollments = DripEnrollment::where('drip_campaign_id', $dripCampaign->id)
            ->with('person')
            ->latest('enrolled_at')
            ->paginate(30);

        $stats = [
            'total'     => DripEnrollment::where('drip_campaign_id', $dripCampaign->id)->count(),
            'active'    => DripEnrollment::where('drip_campaign_id', $dripCampaign->id)->where('status', 'active')->count(),
            'completed' => DripEnrollment::where('drip_campaign_id', $dripCampaign->id)->where('status', 'completed')->count(),
            'cancelled' => DripEnrollment::where('drip_campaign_id', $dripCampaign->id)->where('status', 'cancelled')->count(),
        ];

        $groups = Group::orderBy('name')->get(['id', 'name']);
        $tags   = Tag::orderBy('name')->get(['id', 'name']);

        return view('admin.drip_campaigns.show', compact('dripCampaign', 'enrollments', 'stats', 'groups', 'tags'));
    }

    public function update(Request $request, DripCampaign $dripCampaign)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:200',
            'description'      => 'nullable|string|max:400',
            'trigger_type'     => 'required|in:manual,group_join,tag_added',
            'trigger_group_id' => 'nullable|exists:groups,id',
            'trigger_tag_id'   => 'nullable|exists:tags,id',
        ]);

        $dripCampaign->update($data);

        return back()->with('success', __('drip.updated'));
    }

    public function destroy(DripCampaign $dripCampaign)
    {
        $dripCampaign->delete();
        return redirect()->route('admin.drip-campaigns.index')->with('success', __('drip.deleted'));
    }

    public function toggleStatus(DripCampaign $dripCampaign)
    {
        if ($dripCampaign->isActive()) {
            $dripCampaign->update(['status' => 'paused']);
            $msg = __('drip.paused');
        } else {
            if (!$dripCampaign->steps()->exists()) {
                return back()->with('error', __('drip.no_steps_to_activate'));
            }
            $dripCampaign->update(['status' => 'active']);
            $msg = __('drip.activated');
        }
        return back()->with('success', $msg);
    }

    // ── Steps ──────────────────────────────────────────────────────────────────

    public function storeStep(Request $request, DripCampaign $dripCampaign)
    {
        $data = $request->validate([
            'subject'    => 'required|string|max:255',
            'from_name'  => 'nullable|string|max:100',
            'from_email' => 'nullable|email|max:150',
            'body_html'  => 'required|string',
            'delay_days' => 'required|integer|min:0|max:365',
        ]);

        $position = $dripCampaign->steps()->max('position') + 1;

        $dripCampaign->steps()->create([...$data, 'position' => $position]);

        return back()->with('success', __('drip.step_created'));
    }

    public function updateStep(Request $request, DripCampaign $dripCampaign, DripStep $step)
    {
        abort_if($step->drip_campaign_id !== $dripCampaign->id, 404);

        $data = $request->validate([
            'subject'    => 'required|string|max:255',
            'from_name'  => 'nullable|string|max:100',
            'from_email' => 'nullable|email|max:150',
            'body_html'  => 'required|string',
            'delay_days' => 'required|integer|min:0|max:365',
        ]);

        $step->update($data);

        return back()->with('success', __('drip.step_updated'));
    }

    public function destroyStep(DripCampaign $dripCampaign, DripStep $step)
    {
        abort_if($step->drip_campaign_id !== $dripCampaign->id, 404);
        $step->delete();

        // Re-number positions
        $dripCampaign->steps()->orderBy('position')->each(function ($s, $i) {
            $s->update(['position' => $i + 1]);
        });

        return back()->with('success', __('drip.step_deleted'));
    }

    // ── Enrollments ─────────────────────────────────────────────────────────────

    public function enroll(Request $request, DripCampaign $dripCampaign)
    {
        $request->validate([
            'segment_type'     => 'required|in:all,group,tag,status,person',
            'segment_group_id' => 'nullable|exists:groups,id',
            'segment_tag_id'   => 'nullable|exists:tags,id',
            'segment_statuses' => 'nullable|array',
            'person_id'        => 'nullable|exists:people,id',
        ]);

        if (!$dripCampaign->steps()->exists()) {
            return back()->with('error', __('drip.no_steps_to_enroll'));
        }

        $firstStep = $dripCampaign->steps()->orderBy('position')->first();

        $query = Person::whereNotNull('email')->where('email', '!=', '');

        $type = $request->segment_type;

        if ($type === 'person' && $request->person_id) {
            $query->where('id', $request->person_id);
        } elseif ($type === 'group' && $request->segment_group_id) {
            $query->whereHas('groups', fn ($q) => $q->where('groups.id', $request->segment_group_id));
        } elseif ($type === 'tag' && $request->segment_tag_id) {
            $query->whereHas('tags', fn ($q) => $q->where('tags.id', $request->segment_tag_id));
        } elseif ($type === 'status' && $request->segment_statuses) {
            $query->whereIn('status', $request->segment_statuses);
        } else {
            $query->where('is_subscribed', true);
        }

        // Skip already-enrolled (any status)
        $alreadyEnrolled = DripEnrollment::where('drip_campaign_id', $dripCampaign->id)
            ->pluck('person_id');

        $people = $query->whereNotIn('id', $alreadyEnrolled)->get();

        $count = 0;
        foreach ($people as $person) {
            DripEnrollment::create([
                'drip_campaign_id'   => $dripCampaign->id,
                'person_id'          => $person->id,
                'status'             => 'active',
                'current_step_index' => 0,
                'next_send_at'       => now()->addDays($firstStep->delay_days),
                'enrolled_at'        => now(),
            ]);
            $count++;
        }

        if ($count > 0) {
            WebhookService::dispatch('drip.enrolled', [
                'drip_campaign_id'   => $dripCampaign->id,
                'drip_campaign_name' => $dripCampaign->name,
                'enrolled_count'     => $count,
            ]);
        }

        return back()->with('success', __('drip.enrolled', ['count' => $count]));
    }

    public function cancelEnrollment(DripCampaign $dripCampaign, DripEnrollment $enrollment)
    {
        abort_if($enrollment->drip_campaign_id !== $dripCampaign->id, 404);
        $enrollment->update(['status' => 'cancelled', 'next_send_at' => null]);
        return back()->with('success', __('drip.enrollment_cancelled'));
    }
}
