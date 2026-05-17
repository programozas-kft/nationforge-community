<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendWebhookJob;
use App\Models\Webhook;
use App\Models\WebhookDelivery;
use App\Services\WebhookService;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function index()
    {
        $webhooks   = Webhook::withCount('deliveries')->latest()->get();
        $eventTypes = WebhookService::allEventTypes();
        return view('admin.webhooks.index', compact('webhooks', 'eventTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'url'    => 'required|url|max:500',
            'secret' => 'nullable|string|max:200',
            'events' => 'required|array|min:1',
            'events.*' => 'in:' . implode(',', WebhookService::allEventTypes()),
        ]);

        Webhook::create($request->only('name', 'url', 'secret', 'events'));

        return back()->with('success', __('webhooks.created'));
    }

    public function update(Request $request, Webhook $webhook)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'url'    => 'required|url|max:500',
            'secret' => 'nullable|string|max:200',
            'events' => 'required|array|min:1',
            'events.*' => 'in:' . implode(',', WebhookService::allEventTypes()),
        ]);

        $webhook->update($request->only('name', 'url', 'secret', 'events'));

        return back()->with('success', __('webhooks.updated'));
    }

    public function toggleActive(Webhook $webhook)
    {
        $webhook->update(['is_active' => !$webhook->is_active]);
        return back();
    }

    public function destroy(Webhook $webhook)
    {
        $webhook->delete();
        return back()->with('success', __('webhooks.deleted'));
    }

    public function deliveries(Webhook $webhook)
    {
        $deliveries = $webhook->deliveries()->latest('created_at')->paginate(50);
        return view('admin.webhooks.deliveries', compact('webhook', 'deliveries'));
    }

    public function retry(Webhook $webhook, WebhookDelivery $delivery)
    {
        SendWebhookJob::dispatch($webhook, $delivery->event_type, $delivery->payload['data'] ?? []);
        return back()->with('success', __('webhooks.retry_queued'));
    }
}
