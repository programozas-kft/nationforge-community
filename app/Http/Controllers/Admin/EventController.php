<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderByDesc('starts_at')->paginate(20);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.form', ['event' => new Event()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'type'        => 'required|in:meetup,rally,webinar,fundraiser,volunteer,conference,other',
            'status'      => 'required|in:draft,published,cancelled,completed',
            'starts_at'   => 'required|date',
            'ends_at'     => 'nullable|date|after:starts_at',
            'is_online'   => 'boolean',
            'online_url'  => 'nullable|url',
            'venue_name'  => 'nullable|string|max:200',
            'address'     => 'nullable|string|max:200',
            'city'        => 'nullable|string|max:100',
            'capacity'    => 'nullable|integer|min:1',
            'ticket_price'=> 'nullable|numeric|min:0',
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);
        $data['is_online'] = $request->boolean('is_online');
        $data['ticket_price'] = $data['ticket_price'] ?? 0;
        $data['created_by'] = auth()->id();

        Event::create($data);
        return redirect()->route('admin.events.index')->with('success', 'Esemény létrehozva!');
    }

    public function show(Event $event)
    {
        $event->load([
            'rsvps.person',
            'registrations',
            'shifts.signups.person',
        ]);

        $people = \App\Models\Person::orderBy('last_name')->orderBy('first_name')
            ->get(['id', 'first_name', 'last_name']);

        return view('admin.events.show', compact('event', 'people'));
    }

    public function edit(Event $event)
    {
        return view('admin.events.form', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'type'        => 'required|in:meetup,rally,webinar,fundraiser,volunteer,conference,other',
            'status'      => 'required|in:draft,published,cancelled,completed',
            'starts_at'   => 'required|date',
            'ends_at'     => 'nullable|date|after:starts_at',
            'is_online'   => 'boolean',
            'online_url'  => 'nullable|url',
            'venue_name'  => 'nullable|string|max:200',
            'address'     => 'nullable|string|max:200',
            'city'        => 'nullable|string|max:100',
            'capacity'    => 'nullable|integer|min:1',
            'ticket_price'=> 'nullable|numeric|min:0',
        ]);

        $data['is_online'] = $request->boolean('is_online');
        $data['ticket_price'] = $data['ticket_price'] ?? 0;
        $event->update($data);
        return redirect()->route('admin.events.show', $event)->with('success', 'Esemény frissítve!');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Esemény törölve!');
    }
}
