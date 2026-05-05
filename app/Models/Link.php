<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['title', 'url', 'description', 'category', 'color', 'is_active', 'sort_order'];

    protected $casts = ['is_active' => 'boolean'];
}
