<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = ['name', 'description', 'category', 'body_html', 'is_system'];

    protected $casts = ['is_system' => 'boolean'];
}
