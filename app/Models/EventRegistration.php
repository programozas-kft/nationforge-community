<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $fillable = ['event_id', 'name', 'email', 'phone', 'guests', 'notes', 'token', 'checked_in_at'];

    protected $casts = [
        'checked_in_at' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
