<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactActivity extends Model
{
    protected $fillable = ['person_id', 'user_id', 'type', 'notes', 'occurred_at'];

    protected $casts = ['occurred_at' => 'datetime'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
