<?php

namespace App\Http\Controllers;

use App\Mail\EventRegistrationConfirmation;
use App\Mail\WaitlistConfirmation;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Setting;
use App\Services\BarionPaymentService;
use App\Services\StripePaymentService;
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
        $waitlistCount = $isFull && $event->waitlist_enabled ? $event->waitlist()->count() : 0;

        return view('public.events.show', compact('event', 'registrationCount', 'spotsLeft', 'isFull', 'waitlistCount'));
    }

    public function register(Request $request, string $slug)
    {
        $event = Event::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $registrationCount = $event->registrations()->count();
        $isFull = $event->capacity && $registrationCount >= $event->capacity;

        if ($isFull && ! $event->waitlist_enabled) {
            return back()->withErrors(['capacity' => __('events.full_notice')]);
        }

        $data = $request->validate([
            'name'   => 'required|string|max:120',
            'email'  => 'required|email|max:120',
            'phone'  => 'nullable|string|max:30',
            'guests' => 'nullable|integer|min:0|max:10',
            'notes'  => 'nullable|string|max:500',
        ]);

        $data['event_id'] = $event->id;
        $data['guests']   = $data['guests'] ?? 0;
        $data['token']    = Str::random(48);

        if ($isFull && $event->waitlist_enabled) {
            $nextPosition = ($event->waitlist()->max('waitlist_position') ?? 0) + 1;
            $data['waitlisted']        = true;
            $data['waitlist_position'] = $nextPosition;

            $registration = EventRegistration::create($data);

            try {
                Mail::to($registration->email, $registration->name)
                    ->send(new WaitlistConfirmation($registration->load('event')));
            } catch (\Throwable $e) {
                Log::warning('Waitlist confirmation email failed', [
                    'registration_id' => $registration->id,
                    'error'           => $e->getMessage(),
                ]);
            }

            return redirect()->route('events.waitlisted', $slug)
                ->with('waitlist_position', $nextPosition);
        }

        $registration = EventRegistration::create($data);

        // Fizetéses esemény → átirányítás a fizetési átjáróhoz
        $provider = Setting::get('payment_provider', '');
        if ($event->ticket_price > 0 && $provider) {
            try {
                $url = match ($provider) {
                    'stripe' => (new StripePaymentService())->createCheckoutSession($registration),
                    'barion' => (new BarionPaymentService())->createPayment($registration),
                    default  => null,
                };

                if ($url) {
                    return redirect($url);
                }
            } catch (\Throwable $e) {
                Log::error('Payment init failed', ['error' => $e->getMessage(), 'registration_id' => $registration->id]);
            }

            // Fizetési inicializáció sikertelen → regisztráció törlése, hibaüzenet
            $registration->delete();
            return redirect()->route('events.public', $slug)
                ->with('payment_init_error', __('events.payment_init_error'));
        }

        // Ingyenes esemény → azonnali visszaigazolás
        $registration->update(['payment_status' => 'free']);

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

    public function waitlisted(string $slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $position = session('waitlist_position');

        return view('public.events.waitlisted', compact('event', 'position'));
    }

    public function ticket(string $token)
    {
        $registration = EventRegistration::where('token', $token)
            ->with('event')
            ->firstOrFail();

        return view('public.events.ticket', compact('registration'));
    }
}
