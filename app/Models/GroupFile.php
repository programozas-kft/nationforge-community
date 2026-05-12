<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GroupFile extends Model
{
    protected $fillable = [
        'group_id', 'uploaded_by', 'original_name', 'path',
        'mime_type', 'size', 'description',
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function humanSize(): string
    {
        $bytes = (int) $this->size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 1) . ' KB';
        }
        return $bytes . ' B';
    }

    public function isImage(): bool
    {
        return str_starts_with((string) $this->mime_type, 'image/');
    }

    public function iconKey(): string
    {
        $ext = strtolower(pathinfo($this->original_name, PATHINFO_EXTENSION));
        return match (true) {
            in_array($ext, ['pdf']) => 'pdf',
            in_array($ext, ['doc', 'docx']) => 'doc',
            in_array($ext, ['xls', 'xlsx', 'csv']) => 'xls',
            in_array($ext, ['ppt', 'pptx']) => 'ppt',
            in_array($ext, ['zip', 'rar', '7z']) => 'zip',
            in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']) => 'image',
            in_array($ext, ['txt', 'md']) => 'text',
            default => 'file',
        };
    }

    protected static function booted(): void
    {
        static::deleting(function (GroupFile $file) {
            if ($file->path && Storage::disk('public')->exists($file->path)) {
                Storage::disk('public')->delete($file->path);
            }
        });
    }
}
