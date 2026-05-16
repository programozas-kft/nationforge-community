<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

class AuditObserver
{
    public function created(Model $model): void
    {
        AuditLog::record('created', $model);
    }

    public function updated(Model $model): void
    {
        $changes = [];
        foreach ($model->getChanges() as $field => $newValue) {
            if (in_array($field, AuditLog::SKIP_FIELDS)) continue;
            $changes[$field] = [
                'old' => $model->getOriginal($field),
                'new' => $newValue,
            ];
        }

        if (empty($changes)) return;

        AuditLog::record('updated', $model, $changes);
    }

    public function deleted(Model $model): void
    {
        // Distinguish soft-delete from hard-delete
        $action = method_exists($model, 'trashed') ? 'deleted' : 'deleted';
        AuditLog::record($action, $model);
    }

    public function restored(Model $model): void
    {
        AuditLog::record('restored', $model);
    }
}
