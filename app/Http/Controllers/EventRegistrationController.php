<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventRegistrationController extends Controller
{
    public function show(string $slug)
    {
        $event = Event::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $registrationCount = $event->registrations()->count();
        $spotsLeft = $event->capacity ? $event->capacity - $registrationCount : null;
        $isFull = $spotsLeft !== null && $spotsLeft <= 0;

        return view('public.events.show', compact('event', 'registrationCount', 'spotsLeft', 'isFull'));
    }

    public function register(Request $request, string $slug)
    {
        $event = Event::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $registrationCount = $event->registrations()->count();
        if ($event->capacity && $registrationCount >= $event->capacity) {
            return back()->withErrors(['capacity' => 'Az esemény betelt.']);
        }

        $data = $request->validate([
            'name'   => 'required|string|max:120',
            'email'  => 'required|email|max:120',
            'phone'  => 'nullable|string|max:30',
            'guests' => 'nullable|integer|min:0|max:10',
            'notes'  => 'nullable|string|max:500',
        ]);

        $data['event_id'] = $event->id;
        $data['guests'] = $data['guests'] ?? 0;
        $data['token'] = Str::random(48);

        EventRegistration::create($data);

        return redirect()->route('events.confirmed', $slug);
    }

    public function confirmed(string $slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        return view('public.events.confirmed', compact('event'));
    }
}
