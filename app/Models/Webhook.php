<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Webhook extends Model
{
    protected $fillable = ['name', 'url', 'secret', 'events', 'is_active'];

    protected $casts = [
        'events'    => 'array',
        'is_active' => 'boolean',
    ];

    public function deliveries(): HasMany
    {
        return $this->hasMany(WebhookDelivery::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSubscribedTo($query, string $eventType)
    {
        return $query->whereJsonContains('events', $eventType);
    }

    public function lastDelivery(): ?WebhookDelivery
    {
        return $this->deliveries()->latest('created_at')->first();
    }
}
