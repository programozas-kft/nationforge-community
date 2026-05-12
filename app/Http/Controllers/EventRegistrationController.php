<?php

namespace App\Http\Controllers;

use App\Mail\EventRegistrationConfirmation;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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

        $registration = EventRegistration::create($data);

        try {
            Mail::to($registration->email, $registration->name)
                ->send(new EventRegistrationConfirmation($registration->load('event')));
        } catch (\Throwable $e) {
            Log::warning('Event registration confirmation email failed', [
                'registration_id' => $registration->id,
                'email'           => $registration->email,
                'error'           => $e->getMessage(),
            ]);
        }

        return redirect()->route('events.confirmed', $slug)->with('ticket_token', $registration->token);
    }

    public function confirmed(string $slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $ticketToken = session('ticket_token');

        return view('public.events.confirmed', compact('event', 'ticketToken'));
    }

    public function ticket(string $token)
    {
        $registration = \App\Models\EventRegistration::where('token', $token)
            ->with('event')
            ->firstOrFail();

        return view('public.events.ticket', compact('registration'));
    }
}
