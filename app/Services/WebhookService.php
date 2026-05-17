<?php

namespace App\Services;

use App\Jobs\SendWebhookJob;
use App\Models\Webhook;

class WebhookService
{
    public static function dispatch(string $eventType, array $data): void
    {
        $webhooks = Webhook::active()->subscribedTo($eventType)->get();

        foreach ($webhooks as $webhook) {
            SendWebhookJob::dispatch($webhook, $eventType, $data);
        }
    }

    public static function allEventTypes(): array
    {
        return [
            'contact.created',
            'contact.updated',
            'contact.deleted',
            'event.created',
            'event.registration',
            'donation.created',
            'campaign.sent',
            'task.created',
            'task.completed',
            'drip.enrolled',
            'group.created',
            'group.deleted',
        ];
    }
}
