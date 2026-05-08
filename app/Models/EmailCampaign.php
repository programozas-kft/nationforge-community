<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailCampaign extends Model
{
    protected $fillable = [
        'name', 'subject', 'from_name', 'from_email', 'reply_to',
        'body_html', 'body_text', 'status',
        'sent_at', 'sent_count', 'failed_count', 'recipients_count',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isSent(): bool
    {
        return $this->status === 'sent';
    }
}
