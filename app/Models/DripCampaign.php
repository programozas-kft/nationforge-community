<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DripCampaign extends Model
{
    protected $fillable = [
        'name', 'description', 'status',
        'trigger_type', 'trigger_group_id', 'trigger_tag_id', 'created_by',
    ];

    public function steps()
    {
        return $this->hasMany(DripStep::class)->orderBy('position');
    }

    public function enrollments()
    {
        return $this->hasMany(DripEnrollment::class);
    }

    public function triggerGroup()
    {
        return $this->belongsTo(Group::class, 'trigger_group_id');
    }

    public function triggerTag()
    {
        return $this->belongsTo(Tag::class, 'trigger_tag_id');
    }

    public function isActive(): bool   { return $this->status === 'active'; }
    public function isDraft(): bool    { return $this->status === 'draft'; }
    public function isPaused(): bool   { return $this->status === 'paused'; }

    public function activeEnrollmentsCount(): int
    {
        return $this->enrollments()->where('status', 'active')->count();
    }
}
