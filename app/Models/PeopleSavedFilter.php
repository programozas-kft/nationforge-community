<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeopleSavedFilter extends Model
{
    protected $fillable = ['user_id', 'name', 'filters'];
    protected $casts    = ['filters' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
