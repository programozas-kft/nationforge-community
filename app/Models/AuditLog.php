<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public $timestamps = false;
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id', 'user_name', 'action',
        'auditable_type', 'auditable_id', 'model_label',
        'changes', 'ip_address',
    ];

    protected $casts = [
        'changes'    => 'array',
        'created_at' => 'datetime',
    ];

    const SKIP_FIELDS = [
        'password', 'remember_token', 'two_factor_secret',
        'two_factor_recovery_codes', 'updated_at', 'email_verified_at',
    ];

    public static function record(string $action, Model $model, ?array $changes = null): void
    {
        $user = auth()->user();

        static::create([
            'user_id'        => $user?->id,
            'user_name'      => $user?->name ?? 'System',
            'action'         => $action,
            'auditable_type' => class_basename($model),
            'auditable_id'   => $model->getKey(),
            'model_label'    => static::resolveLabel($model),
            'changes'        => $changes,
            'ip_address'     => request()->ip(),
        ]);
    }

    public static function resolveLabel(Model $model): string
    {
        foreach (['name', 'title'] as $field) {
            if (!empty($model->$field)) return $model->$field;
        }
        if (!empty($model->first_name)) {
            return trim($model->first_name . ' ' . ($model->last_name ?? ''));
        }
        if (!empty($model->email)) return $model->email;
        return '#' . $model->getKey();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
