<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps  = false;
    public $incrementing = false;
    protected $primaryKey = 'key';
    protected $keyType    = 'string';
    protected $fillable   = ['key', 'value'];

    public static function get(string $key, mixed $default = null): mixed
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function darken(string $hex, int $percent = 15): string
    {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }
        $r = (int)(hexdec(substr($hex, 0, 2)) * (1 - $percent / 100));
        $g = (int)(hexdec(substr($hex, 2, 2)) * (1 - $percent / 100));
        $b = (int)(hexdec(substr($hex, 4, 2)) * (1 - $percent / 100));
        return sprintf('#%02x%02x%02x', max(0, $r), max(0, $g), max(0, $b));
    }
}
