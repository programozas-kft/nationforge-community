<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DonationFormController;
use App\Mail\EventRegistrationConfirmation;
use App\Models\Donation;
use App\Models\EventRegistration;
use App\Models\Setting;
use App\Services\BarionPaymentService;
use App\Services\StripePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    // ── Stripe ───────────────────────────────────────────────────

    public function stripeSuccess(string $token, Request $request)
    {
        $registration = EventRegistration::where('token', $token)->with('event')->firstOrFail();

        if ($registration->payment_status === 'paid') {
            return redirect()->route('events.confirmed', $registration->event->slug)
                ->with('ticket_token', $token);
        }

        $sessionId = $request->query('session_id');
        if (!$sessionId) {
            return redirect()->route('events.public', $registration->event->slug)
                ->with('payment_error', __('events.payment_error'));
        }

        $ok = false;
        try {
            $ok = (new StripePaymentService())->confirmSession($sessionId, $registration);
        } catch (\Throwable $e) {
            Log::error('Stripe confirm failed', ['error' => $e->getMessage(), 'token' => $token]);
        }

        if ($ok) {
            $this->sendConfirmation($registration);
            return redirect()->route('events.confirmed', $registration->event->slug)
                ->with('ticket_token', $token);
        }

        $registration->update(['payment_status' => 'failed']);
        return redirect()->route('events.public', $registration->event->slug)
            ->with('payment_error', __('events.payment_error'));
    }

    public function stripeCancel(string $token)
    {
        $registration = EventRegistration::where('token', $token)->with('event')->firstOrFail();

        if ($registration->payment_status === 'pending') {
            $registration->update(['payment_status' => 'failed']);
        }

        return redirect()->route('events.public', $registration->event->slug)
            ->with('payment_cancelled', __('events.payment_cancelled'));
    }

    public function stripeWebhook(Request $request)
    {
        $secret    = Setting::get('stripe_webhook_secret', '');
        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature', '');

        try {
            $event = (new StripePaymentService())->constructWebhookEvent($payload, $sigHeader, $secret);
        } catch (\Throwable $e) {
            Log::warning('Stripe webhook signature invalid', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $regToken = $session->metadata->registration_token ?? null;
            if ($regToken) {
                $registration = EventRegistration::where('token', $regToken)->with('event')->first();
                if ($registration && $registration->payment_status === 'pending') {
                    $registration->update([
                        'payment_status' => 'paid',
                        'paid_amount'    => $registration->event->ticket_price * ($registration->guests + 1),
                    ]);
                    $this->sendConfirmation($registration);
                }
            }

            $donationToken = $session->metadata->donation_token ?? null;
            if ($donationToken) {
                $donation = Donation::where('token', $donationToken)->first();
                if ($donation && $donation->status === 'pending') {
                    $donation->update(['status' => 'completed']);
                    DonationFormController::sendConfirmation($donation);
                }
            }
        }

        return response()->json(['ok' => true]);
    }

    // ── Barion ───────────────────────────────────────────────────

    public function barionCallback(string $token, Request $request)
    {
        $registration = EventRegistration::where('token', $token)->with('event')->firstOrFail();

        if ($registration->payment_status === 'paid') {
            return redirect()->route('events.confirmed', $registration->event->slug)
                ->with('ticket_token', $token);
        }

        $paymentId = $request->query('paymentId') ?? $registration->payment_intent_id;
        $ok        = false;

        try {
            $ok = $paymentId && (new BarionPaymentService())->verifyPayment($paymentId);
        } catch (\Throwable $e) {
            Log::error('Barion verify failed', ['error' => $e->getMessage(), 'token' => $token]);
        }

        if ($ok) {
            $registration->update(['payment_status' => 'paid']);
            $this->sendConfirmation($registration);
            return redirect()->route('events.confirmed', $registration->event->slug)
                ->with('ticket_token', $token);
        }

        $registration->update(['payment_status' => 'failed']);
        return redirect()->route('events.public', $registration->event->slug)
            ->with('payment_error', __('events.payment_error'));
    }

    // Barion IPN — szerver-szerver GET hívás
    public function barionIpn(Request $request)
    {
        $paymentId = $request->query('paymentId');
        if (!$paymentId) {
            return response('', 400);
        }

        $registration = EventRegistration::where('payment_intent_id', $paymentId)->with('event')->first();

        if (!$registration || $registration->payment_status === 'paid') {
            return response('', 200);
        }

        try {
            if ((new BarionPaymentService())->verifyPayment($paymentId)) {
                $registration->update(['payment_status' => 'paid']);
                $this->sendConfirmation($registration);
            }
        } catch (\Throwable $e) {
            Log::error('Barion IPN error', ['error' => $e->getMessage()]);
        }

        return response('', 200);
    }

    // ── Donation callbacks ────────────────────────────────────────

    public function stripeSuccessDonation(string $token, Request $request)
    {
        $donation  = Donation::where('token', $token)->firstOrFail();
        $sessionId = $request->query('session_id');

        if ($donation->status === 'completed') {
            return redirect()->route('donate.thanks', $token);
        }

        $ok = false;
        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            \Stripe\Stripe::setApiKey(Setting::get('stripe_secret_key', ''));
            if ($session->payment_status === 'paid') {
                $donation->update(['status' => 'completed']);
                DonationFormController::sendConfirmation($donation);
                $ok = true;
            }
        } catch (\Throwable $e) {
            Log::error('Donation Stripe confirm failed', ['error' => $e->getMessage(), 'token' => $token]);
        }

        if (!$ok) {
            $donation->update(['status' => 'failed']);
            return redirect()->route('donate')->with('payment_error', __('donations.payment_error'));
        }

        return redirect()->route('donate.thanks', $token);
    }

    public function stripeCancelDonation(string $token)
    {
        $donation = Donation::where('token', $token)->firstOrFail();
        if ($donation->status === 'pending') {
            $donation->update(['status' => 'failed']);
        }
        return redirect()->route('donate')->with('payment_error', __('donations.payment_cancelled'));
    }

    public function barionCallbackDonation(string $token, Request $request)
    {
        $donation  = Donation::where('token', $token)->firstOrFail();
        $paymentId = $request->query('paymentId') ?? $donation->transaction_id;

        if ($donation->status === 'completed') {
            return redirect()->route('donate.thanks', $token);
        }

        $ok = false;
        try {
            $ok = $paymentId && (new BarionPaymentService())->verifyPayment($paymentId);
        } catch (\Throwable $e) {
            Log::error('Donation Barion verify failed', ['error' => $e->getMessage(), 'token' => $token]);
        }

        if ($ok) {
            $donation->update(['status' => 'completed']);
            DonationFormController::sendConfirmation($donation);
            return redirect()->route('donate.thanks', $token);
        }

        $donation->update(['status' => 'failed']);
        return redirect()->route('donate')->with('payment_error', __('donations.payment_error'));
    }

    // ── Segéd ────────────────────────────────────────────────────

    private function sendConfirmation(EventRegistration $registration): void
    {
        try {
            Mail::to($registration->email, $registration->name)
                ->send(new EventRegistrationConfirmation($registration->load('event')));
        } catch (\Throwable $e) {
            Log::warning('Payment confirmation email failed', [
                'registration_id' => $registration->id,
                'error'           => $e->getMessage(),
            ]);
        }
    }
}
