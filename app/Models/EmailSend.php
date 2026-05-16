<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSend extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'campaign_id', 'person_id', 'tracking_token',
        'sent_at', 'opened_at', 'clicked_at',
    ];

    protected $casts = [
        'sent_at'    => 'datetime',
        'opened_at'  => 'datetime',
        'clicked_at' => 'datetime',
    ];

    public function campaign()
    {
        return $this->belongsTo(EmailCampaign::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
