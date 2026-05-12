<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerSignup extends Model
{
    protected $fillable = [
        'shift_id', 'person_id', 'status', 'notes', 'attended',
    ];

    protected $casts = [
        'attended' => 'boolean',
    ];

    public function shift()
    {
        return $this->belongsTo(VolunteerShift::class, 'shift_id');
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
