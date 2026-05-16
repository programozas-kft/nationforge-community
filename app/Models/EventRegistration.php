<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $fillable = [
        'event_id', 'name', 'email', 'phone', 'guests', 'notes', 'token',
        'checked_in_at', 'waitlisted', 'waitlist_position',
        'payment_status', 'payment_provider', 'payment_intent_id', 'paid_amount',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
        'waitlisted'    => 'boolean',
        'paid_amount'   => 'integer',
    ];

    public function isPaid(): bool
    {
        return in_array($this->payment_status, ['free', 'paid']);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
