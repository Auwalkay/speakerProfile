<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditObserver
{
    public function created(Model $model): void
    {
        $this->logAction($model, 'create', null, $model->getAttributes());
    }

    public function updated(Model $model): void
    {
        $old = array_intersect_key($model->getRawOriginal(), $model->getDirty());
        $new = $model->getDirty();

        // Custom transition logger
        $action = 'update';
        if (isset($new['status'])) {
            $action = match ($new['status']) {
                'published' => 'publish',
                'approved' => 'approve',
                'archived' => 'archive',
                default => 'update',
            };
        }

        $this->logAction($model, $action, $old, $new);
    }

    public function deleted(Model $model): void
    {
        $this->logAction($model, 'delete', $model->getAttributes(), null);
    }

    protected function logAction(Model $model, string $action, ?array $old, ?array $new): void
    {
        // Don't log recursive audits
        if ($model instanceof AuditLog) {
            return;
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'old_values' => $old,
            'new_values' => $new,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
