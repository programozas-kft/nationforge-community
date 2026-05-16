<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DripEnrollment extends Model
{
    protected $fillable = [
        'drip_campaign_id', 'person_id', 'status',
        'current_step_index', 'next_send_at', 'enrolled_at', 'completed_at',
    ];

    protected $casts = [
        'next_send_at'  => 'datetime',
        'enrolled_at'   => 'datetime',
        'completed_at'  => 'datetime',
    ];

    public function dripCampaign()
    {
        return $this->belongsTo(DripCampaign::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
