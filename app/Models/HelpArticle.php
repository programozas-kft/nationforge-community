<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpArticle extends Model
{
    protected $fillable = ['menu_key', 'title', 'title_en', 'content', 'content_en', 'sort_order'];
}
