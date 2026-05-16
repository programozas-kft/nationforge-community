<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpArticle extends Model
{
    protected $fillable = ['menu_key', 'title', 'title_en', 'content', 'content_en', 'sort_order', 'video_url'];

    public static function toEmbedUrl(?string $url): ?string
    {
        if (!$url) return null;

        // YouTube: youtu.be/ID or youtube.com/watch?v=ID or youtube.com/embed/ID
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]{11})/', $url, $m) ||
            preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})/', $url, $m) ||
            preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }

        // Vimeo: vimeo.com/ID or player.vimeo.com/video/ID
        if (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $url, $m)) {
            return 'https://player.vimeo.com/video/' . $m[1];
        }

        return null;
    }
}
