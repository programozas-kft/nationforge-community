<?php

namespace App\Jobs;

use App\Models\Webhook;
use App\Models\WebhookDelivery;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 60;

    public function __construct(
        private readonly Webhook $webhook,
        private readonly string  $eventType,
        private readonly array   $data,
    ) {}

    public function handle(): void
    {
        $payload = [
            'event'     => $this->eventType,
            'timestamp' => now()->toIso8601String(),
            'data'      => $this->data,
        ];

        $body = json_encode($payload);

        $headers = [
            'Content-Type'    => 'application/json',
            'User-Agent'      => 'NationForge-Webhook/1.0',
            'X-NationForge-Event' => $this->eventType,
        ];

        if ($this->webhook->secret) {
            $headers['X-NationForge-Signature'] = 'sha256=' . hash_hmac('sha256', $body, $this->webhook->secret);
        }

        $delivery = WebhookDelivery::create([
            'webhook_id'    => $this->webhook->id,
            'event_type'    => $this->eventType,
            'payload'       => $payload,
            'status'        => 'pending',
            'attempt_count' => $this->attempts(),
            'created_at'    => now(),
        ]);

        try {
            $response = Http::withHeaders($headers)
                ->timeout(10)
                ->withBody($body, 'application/json')
                ->post($this->webhook->url);

            $delivery->update([
                'response_code' => $response->status(),
                'response_body' => substr($response->body(), 0, 2000),
                'status'        => $response->successful() ? 'success' : 'failed',
                'delivered_at'  => now(),
            ]);

            if (!$response->successful()) {
                $this->fail("HTTP {$response->status()}");
            }
        } catch (\Throwable $e) {
            $delivery->update([
                'response_body' => $e->getMessage(),
                'status'        => 'failed',
            ]);

            throw $e;
        }
    }
}
