<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerShift extends Model
{
    protected $fillable = [
        'title', 'description', 'event_id',
        'starts_at', 'ends_at', 'location',
        'slots', 'filled_slots', 'created_by',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
        'slots'     => 'integer',
        'filled_slots' => 'integer',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function signups()
    {
        return $this->hasMany(VolunteerSignup::class, 'shift_id');
    }

    public function activeSignups()
    {
        return $this->hasMany(VolunteerSignup::class, 'shift_id')
            ->where('status', '!=', 'cancelled');
    }

    public function hasOpenSlot(): bool
    {
        return $this->slots > $this->filled_slots;
    }

    public function recalcFilled(): void
    {
        $count = $this->signups()->where('status', 'confirmed')->count();
        $this->forceFill(['filled_slots' => $count])->save();
    }
}
