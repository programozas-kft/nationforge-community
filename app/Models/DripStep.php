<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DripStep extends Model
{
    protected $fillable = [
        'drip_campaign_id', 'position', 'subject',
        'from_name', 'from_email', 'body_html', 'delay_days',
    ];

    public function campaign()
    {
        return $this->belongsTo(DripCampaign::class, 'drip_campaign_id');
    }

    public function delayLabel(): string
    {
        if ($this->delay_days === 0) {
            return __('drip.delay_immediately');
        }
        return __('drip.delay_after_days', ['days' => $this->delay_days]);
    }
}
