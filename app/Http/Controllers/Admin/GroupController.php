<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::withCount(['people', 'users'])->orderBy('name')->paginate(20);
        return view('admin.groups.index', compact('groups'));
    }

    public function create()
    {
        return view('admin.groups.form', ['group' => new Group()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:200',
            'description' => 'nullable|string',
            'type'        => 'required|in:community,campaign,chapter,committee,team',
            'privacy'     => 'required|in:public,private,secret',
            'is_active'   => 'boolean',
            'icon'        => 'nullable|string|max:50',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(5);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['created_by'] = auth()->id();

        Group::create($data);
        return redirect()->route('admin.groups.index')->with('success', 'Csoport létrehozva!');
    }

    public function show(Group $group, Request $request)
    {
        $group->load(['people', 'users.roles', 'files.uploader']);

        // Calendar month derived from ?cal=YYYY-MM (defaults to current month)
        $cal = $request->query('cal');
        try {
            $month = $cal ? Carbon::createFromFormat('Y-m', $cal)->startOfMonth() : Carbon::now()->startOfMonth();
        } catch (\Throwable) {
            $month = Carbon::now()->startOfMonth();
        }

        $events = $group->events()
            ->whereBetween('starts_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
            ->orderBy('starts_at')
            ->get()
            ->groupBy(fn ($e) => $e->starts_at->format('Y-m-d'));

        return view('admin.groups.show', compact('group', 'month', 'events'));
    }

    public function storeEvent(Request $request, Group $group)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:200',
            'type'       => 'required|in:meetup,rally,webinar,fundraiser,volunteer,conference,other',
            'starts_at'  => 'required|date',
            'ends_at'    => 'nullable|date|after:starts_at',
            'is_online'  => 'boolean',
            'online_url' => 'nullable|url',
            'venue_name' => 'nullable|string|max:200',
            'city'       => 'nullable|string|max:100',
            'description'=> 'nullable|string',
        ]);

        $data['slug']       = Str::slug($data['title']) . '-' . Str::random(5);
        $data['status']     = 'published';
        $data['is_online']  = $request->boolean('is_online');
        $data['created_by'] = auth()->id();
        $data['group_id']   = $group->id;

        Event::create($data);

        $month = Carbon::parse($data['starts_at'])->format('Y-m');
        return redirect()->route('admin.groups.show', ['group' => $group, 'cal' => $month])
            ->with('success', __('group_calendar.created'));
    }

    public function edit(Group $group)
    {
        return view('admin.groups.form', compact('group'));
    }

    public function update(Request $request, Group $group)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:200',
            'description' => 'nullable|string',
            'type'        => 'required|in:community,campaign,chapter,committee,team',
            'privacy'     => 'required|in:public,private,secret',
            'is_active'   => 'boolean',
            'icon'        => 'nullable|string|max:50',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $group->update($data);
        return redirect()->route('admin.groups.show', $group)->with('success', 'Csoport frissítve!');
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('admin.groups.index')->with('success', 'Csoport törölve!');
    }
}
