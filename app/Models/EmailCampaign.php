<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailCampaign extends Model
{
    protected $fillable = [
        'name', 'subject', 'from_name', 'from_email', 'reply_to',
        'body_html', 'body_text', 'status',
        'sent_at', 'sent_count', 'failed_count', 'recipients_count',
        'segment_filters',
    ];

    protected $casts = [
        'sent_at'         => 'datetime',
        'segment_filters' => 'array',
    ];

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isSent(): bool
    {
        return $this->status === 'sent';
    }

    public function buildRecipientsQuery()
    {
        $query = Person::whereNotNull('email')
            ->where('email', '!=', '')
            ->where('is_subscribed', true);

        $filters = $this->segment_filters ?? [];
        $type    = $filters['type'] ?? 'all';

        if ($type === 'group' && !empty($filters['group_ids'])) {
            $query->whereHas('groups', fn ($q) => $q->whereIn('groups.id', $filters['group_ids']));
        } elseif ($type === 'tag' && !empty($filters['tag_ids'])) {
            $query->whereHas('tags', fn ($q) => $q->whereIn('tags.id', $filters['tag_ids']));
        } elseif ($type === 'status' && !empty($filters['statuses'])) {
            $query->whereIn('status', $filters['statuses']);
        }

        return $query;
    }

    public function segmentLabel(): string
    {
        $filters = $this->segment_filters ?? [];
        $type    = $filters['type'] ?? 'all';

        return match ($type) {
            'group'  => 'group',
            'tag'    => 'tag',
            'status' => 'status',
            default  => 'all',
        };
    }
}
