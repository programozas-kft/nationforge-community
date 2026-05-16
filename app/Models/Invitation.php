<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invitation extends Model
{
    public $timestamps = false;
    const UPDATED_AT = null;

    protected $fillable = [
        'email', 'role', 'token',
        'invited_by', 'invited_by_name',
        'expires_at', 'used_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at'    => 'datetime',
        'created_at' => 'datetime',
    ];

    public static function generate(string $email, string $role): static
    {
        $user = auth()->user();

        return static::create([
            'email'           => $email,
            'role'            => $role,
            'token'           => Str::random(48),
            'invited_by'      => $user?->id,
            'invited_by_name' => $user?->name,
            'expires_at'      => now()->addDays(7),
        ]);
    }

    public function isPending(): bool
    {
        return is_null($this->used_at) && $this->expires_at->isFuture();
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast() && is_null($this->used_at);
    }

    public function registrationUrl(): string
    {
        return route('invite.register', $this->token);
    }
}
