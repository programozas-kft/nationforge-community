<?php

namespace App\Services;

use App\Models\EventRegistration;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class BarionPaymentService
{
    private string $posKey;
    private string $merchantEmail;
    private string $baseUrl;

    public function __construct()
    {
        $this->posKey        = Setting::get('barion_api_key', '');
        $this->merchantEmail = Setting::get('barion_merchant_email', '');
        $this->baseUrl       = Setting::get('barion_environment', 'test') === 'live'
            ? 'https://api.barion.com'
            : 'https://api.test.barion.com';
    }

    public function createPayment(EventRegistration $registration): ?string
    {
        $event    = $registration->event;
        $quantity = $registration->guests + 1;
        $total    = $event->ticket_price * $quantity;
        $txId     = 'NF-' . Str::upper(Str::random(12));

        $response = Http::post($this->baseUrl . '/v2/Payment/Start', [
            'POSKey'        => $this->posKey,
            'PaymentType'   => 'Immediate',
            'GuestCheckOut' => true,
            'FundingSources'=> ['All'],
            'PaymentRequestId' => $txId,
            'PayerHint'     => $registration->email,
            'Transactions'  => [[
                'POSTransactionId' => $txId,
                'Payee'            => $this->merchantEmail,
                'Total'            => $total,
                'Comment'          => 'Belépőjegy — ' . $event->title,
                'Items'            => [[
                    'Name'        => $event->title,
                    'Description' => 'Belépőjegy',
                    'Quantity'    => $quantity,
                    'Unit'        => 'db',
                    'UnitPrice'   => $event->ticket_price,
                    'ItemTotal'   => $total,
                    'SKU'         => 'ticket-' . $event->id,
                ]],
            ]],
            'Currency'    => 'HUF',
            'RedirectUrl' => route('payment.barion.callback', $registration->token),
            'CallbackUrl' => route('payment.barion.ipn'),
        ]);

        if (!$response->successful()) {
            return null;
        }

        $data      = $response->json();
        $paymentId = $data['PaymentId'] ?? null;

        if (!$paymentId || !empty($data['Errors'])) {
            return null;
        }

        $registration->update([
            'payment_status'    => 'pending',
            'payment_provider'  => 'barion',
            'payment_intent_id' => $paymentId,
            'paid_amount'       => $total,
        ]);

        return $data['GatewayUrl'] ?? null;
    }

    public function verifyPayment(string $paymentId): bool
    {
        $response = Http::get($this->baseUrl . '/v2/Payment/GetPaymentState', [
            'POSKey'    => $this->posKey,
            'PaymentId' => $paymentId,
        ]);

        if (!$response->successful()) {
            return false;
        }

        return ($response->json('Status') ?? '') === 'Succeeded';
    }
}
