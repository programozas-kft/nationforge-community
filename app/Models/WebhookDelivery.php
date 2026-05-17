<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebhookDelivery extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'webhook_id', 'event_type', 'payload',
        'response_code', 'response_body', 'status',
        'attempt_count', 'delivered_at', 'created_at',
    ];

    protected $casts = [
        'payload'      => 'array',
        'delivered_at' => 'datetime',
        'created_at'   => 'datetime',
    ];

    public function webhook(): BelongsTo
    {
        return $this->belongsTo(Webhook::class);
    }

    public function isSuccess(): bool
    {
        return $this->status === 'success';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }
}
