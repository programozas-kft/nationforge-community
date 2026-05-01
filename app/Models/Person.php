<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Person extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'email', 'phone', 'mobile',
        'birthdate', 'gender', 'address', 'city', 'county', 'postal_code',
        'country', 'occupation', 'employer', 'bio', 'avatar',
        'facebook_url', 'twitter_url', 'linkedin_url', 'website',
        'status', 'total_donated', 'donation_count', 'last_donated_at',
        'last_contacted_at', 'is_subscribed', 'unsubscribe_token',
        'custom_fields', 'source', 'notes', 'photo',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'last_donated_at' => 'datetime',
        'last_contacted_at' => 'datetime',
        'is_subscribed' => 'boolean',
        'custom_fields' => 'array',
        'total_donated' => 'decimal:2',
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->last_name} {$this->first_name}";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_person')
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function eventRsvps()
    {
        return $this->hasMany(EventRsvp::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function volunteerSignups()
    {
        return $this->hasMany(VolunteerSignup::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'inactive');
    }

    public function scopeSubscribed($query)
    {
        return $query->where('is_subscribed', true);
    }
}
