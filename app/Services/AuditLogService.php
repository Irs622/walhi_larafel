<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class AuditLogService
{
    /**
     * Log an admin action to the audit trail.
     *
     * @param  string  $action  (e.g. 'CONTENT_CREATE', 'CONTENT_UPDATE', 'COMMENT_DELETE')
     * @param  int|string|null  $modelId
     */
    public static function log(string $action, string $modelName, mixed $modelId = null, array $details = []): void
    {
        $user = auth()->user();

        Log::info("Audit Trail: Action [{$action}] on [{$modelName}]", [
            'user_id' => $user?->id,
            'user_email' => $user?->email,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'model' => $modelName,
            'model_id' => $modelId,
            'timestamp' => now()->toIso8601String(),
            'details' => $details,
        ]);
    }
}
