<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CampaignMail;
use App\Models\EmailCampaign;
use App\Models\EmailSend;
use App\Models\Group;
use App\Models\Person;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Services\WebhookService;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = EmailCampaign::latest()->get();
        $groups    = Group::orderBy('name')->get(['id', 'name']);
        $tags      = Tag::orderBy('name')->get(['id', 'name', 'color']);

        $subscriberCount = Person::whereNotNull('email')
            ->where('email', '!=', '')
            ->where('is_subscribed', true)
            ->count();

        return view('admin.campaigns.index', compact('campaigns', 'subscriberCount', 'groups', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:200',
            'subject'    => 'required|string|max:255',
            'body_html'  => 'required|string',
            'from_name'  => 'nullable|string|max:100',
            'from_email' => 'nullable|email|max:150',
        ]);

        EmailCampaign::create([
            'name'            => $request->name,
            'subject'         => $request->subject,
            'body_html'       => $request->body_html,
            'from_name'       => $request->from_name  ?: config('mail.from.name'),
            'from_email'      => $request->from_email ?: config('mail.from.address'),
            'status'          => 'draft',
            'segment_filters' => $this->parseSegmentFilters($request),
        ]);

        return back()->with('success', __('campaigns.created'));
    }

    public function update(Request $request, EmailCampaign $campaign)
    {
        if (! $campaign->isDraft()) {
            return back()->with('error', __('campaigns.cannot_edit_sent'));
        }

        $request->validate([
            'name'       => 'required|string|max:200',
            'subject'    => 'required|string|max:255',
            'body_html'  => 'required|string',
            'from_name'  => 'nullable|string|max:100',
            'from_email' => 'nullable|email|max:150',
        ]);

        $campaign->update([
            ...$request->only('name', 'subject', 'body_html', 'from_name', 'from_email'),
            'segment_filters' => $this->parseSegmentFilters($request),
        ]);

        return back()->with('success', __('campaigns.updated'));
    }

    public function destroy(EmailCampaign $campaign)
    {
        $campaign->delete();
        return back()->with('success', __('campaigns.deleted'));
    }

    public function send(EmailCampaign $campaign)
    {
        if (! $campaign->isDraft()) {
            return back()->with('error', __('campaigns.already_sent'));
        }

        $resendKey = config('services.resend.key');
        if (empty($resendKey)) {
            return back()->with('error', __('campaigns.no_resend_key'));
        }

        $recipients = $campaign->buildRecipientsQuery()->get();

        if ($recipients->isEmpty()) {
            return back()->with('error', __('campaigns.no_recipients'));
        }

        $campaign->update(['status' => 'sending']);

        $sent   = 0;
        $failed = 0;

        foreach ($recipients as $person) {
            $token = Str::random(40);

            EmailSend::create([
                'campaign_id'    => $campaign->id,
                'person_id'      => $person->id,
                'tracking_token' => $token,
                'sent_at'        => now(),
            ]);

            try {
                Mail::to($person->email, $person->full_name)
                    ->send(new CampaignMail($campaign, $person, $token));
                $sent++;
            } catch (\Exception) {
                $failed++;
            }
        }

        $campaign->update([
            'status'           => ($failed > 0 && $sent === 0) ? 'failed' : 'sent',
            'sent_at'          => now(),
            'sent_count'       => $sent,
            'failed_count'     => $failed,
            'recipients_count' => $recipients->count(),
        ]);

        WebhookService::dispatch('campaign.sent', [
            'id'               => $campaign->id,
            'subject'          => $campaign->subject,
            'sent_count'       => $sent,
            'failed_count'     => $failed,
            'recipients_count' => $recipients->count(),
            'sent_at'          => now()->toIso8601String(),
        ]);

        return back()->with('success', __('campaigns.sent_ok', ['count' => $sent]));
    }

    public function recipientCount(Request $request)
    {
        $temp = new EmailCampaign([
            'segment_filters' => $this->parseSegmentFilters($request),
        ]);

        return response()->json(['count' => $temp->buildRecipientsQuery()->count()]);
    }

    private function parseSegmentFilters(Request $request): array
    {
        $type    = $request->input('segment_type', 'all');
        $filters = ['type' => $type];

        if ($type === 'group') {
            $filters['group_ids'] = array_map('intval', (array) $request->input('segment_group_ids', []));
        } elseif ($type === 'tag') {
            $filters['tag_ids'] = array_map('intval', (array) $request->input('segment_tag_ids', []));
        } elseif ($type === 'status') {
            $filters['statuses'] = (array) $request->input('segment_statuses', []);
        }

        return $filters;
    }
}
