<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

class AuditObserver
{
    private function log(Model $model, string $action)
    {
        if (!auth()->check()) {
            return;
        }

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'module' => class_basename($model),
            'ip_address' => request()->ip(),
            'details' => [
                'id' => $model->getKey(),
                'changes' => $action === 'updated' ? $model->getChanges() : $model->toArray(),
            ]
        ]);
    }

    public function created(Model $model): void
    {
        $this->log($model, 'created');
    }

    public function updated(Model $model): void
    {
        $this->log($model, 'updated');
    }

    public function deleted(Model $model): void
    {
        $this->log($model, 'deleted');
    }
}
