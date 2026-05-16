<?php

namespace App\Services;

use App\Models\Donation;
use App\Models\EventRegistration;
use App\Models\Setting;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Webhook;

class StripePaymentService
{
    public function __construct()
    {
        Stripe::setApiKey(Setting::get('stripe_secret_key', ''));
    }

    public function createCheckoutSession(EventRegistration $registration): string
    {
        $event    = $registration->event;
        $quantity = $registration->guests + 1;

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [[
                'price_data' => [
                    'currency'     => 'huf',
                    // HUF has 2 decimal places in Stripe (× 100 → fillér)
                    'unit_amount'  => $event->ticket_price * 100,
                    'product_data' => ['name' => $event->title],
                ],
                'quantity' => $quantity,
            ]],
            'mode'           => 'payment',
            'customer_email' => $registration->email,
            'success_url'    => route('payment.stripe.success', $registration->token) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'     => route('payment.stripe.cancel', $registration->token),
            'metadata'       => ['registration_token' => $registration->token],
        ]);

        $registration->update([
            'payment_status'    => 'pending',
            'payment_provider'  => 'stripe',
            'payment_intent_id' => $session->id,
        ]);

        return $session->url;
    }

    public function confirmSession(string $sessionId, EventRegistration $registration): bool
    {
        $session = Session::retrieve($sessionId);

        if ($session->payment_status !== 'paid') {
            return false;
        }

        $registration->update([
            'payment_status' => 'paid',
            'paid_amount'    => $registration->event->ticket_price * ($registration->guests + 1),
        ]);

        return true;
    }

    public function createDonationSession(Donation $donation): string
    {
        $currency   = strtolower($donation->currency);
        $unitAmount = (int) ($donation->amount * 100); // Stripe uses smallest currency unit

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [[
                'price_data' => [
                    'currency'     => $currency,
                    'unit_amount'  => $unitAmount,
                    'product_data' => ['name' => Setting::get('brand_org_name', config('app.name')) . ' – Donation'],
                ],
                'quantity' => 1,
            ]],
            'mode'           => 'payment',
            'customer_email' => $donation->donor_email ?: null,
            'success_url'    => route('payment.donation.stripe.success', $donation->token) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'     => route('payment.donation.stripe.cancel', $donation->token),
            'metadata'       => ['donation_token' => $donation->token],
        ]);

        $donation->update([
            'payment_method' => 'stripe',
            'transaction_id' => $session->id,
        ]);

        return $session->url;
    }

    public function constructWebhookEvent(string $payload, string $sigHeader, string $secret): \Stripe\Event
    {
        return Webhook::constructEvent($payload, $sigHeader, $secret);
    }
}
