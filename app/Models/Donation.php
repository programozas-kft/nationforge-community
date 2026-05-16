<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'token', 'person_id', 'donor_name', 'donor_email',
        'amount', 'currency', 'status', 'payment_method',
        'transaction_id', 'campaign', 'message', 'is_recurring',
        'recurring_interval', 'next_charge_at', 'is_anonymous', 'payment_data',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_recurring' => 'boolean',
        'is_anonymous' => 'boolean',
        'next_charge_at' => 'datetime',
        'payment_data' => 'array',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
