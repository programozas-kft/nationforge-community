<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DripSend extends Model
{
    protected $fillable = [
        'drip_step_id', 'drip_enrollment_id', 'person_id', 'tracking_token',
        'sent_at', 'opened_at', 'clicked_at',
    ];

    protected $casts = [
        'sent_at'    => 'datetime',
        'opened_at'  => 'datetime',
        'clicked_at' => 'datetime',
    ];

    public function dripStep()
    {
        return $this->belongsTo(DripStep::class);
    }

    public function enrollment()
    {
        return $this->belongsTo(DripEnrollment::class, 'drip_enrollment_id');
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
