<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'description', 'cover_image', 'type', 'status',
        'starts_at', 'ends_at', 'is_online', 'online_url', 'venue_name',
        'address', 'city', 'postal_code', 'latitude', 'longitude',
        'capacity', 'ticket_price', 'created_by', 'group_id',
        'rsvp_count', 'is_featured', 'custom_fields',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_online' => 'boolean',
        'is_featured' => 'boolean',
        'custom_fields' => 'array',
        'ticket_price' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function rsvps()
    {
        return $this->hasMany(EventRsvp::class);
    }

    public function shifts()
    {
        return $this->hasMany(VolunteerShift::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('starts_at', '>', now())->orderBy('starts_at');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
