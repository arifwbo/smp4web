<?php

namespace App\Support;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log(string $action, string $description, ?int $userId = null, ?array $before = null, ?array $after = null): void
    {
        $request = request();

        ActivityLog::create([
            'user_id' => $userId ?? Auth::id(),
            'action' => $action,
            'description' => $description,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
            'properties_before' => $before,
            'properties_after' => $after,
        ]);
    }

    public static function logModelChange(string $action, string $description, ?Model $model = null, ?array $before = null): void
    {
        $after = $model?->toArray();
        $beforePayload = $before ?? $model?->getOriginal();

        static::log($action, $description, null, $beforePayload, $after);
    }
}
