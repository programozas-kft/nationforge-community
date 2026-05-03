<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRsvp extends Model
{
    protected $fillable = ['event_id', 'person_id', 'status', 'guests', 'notes'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
