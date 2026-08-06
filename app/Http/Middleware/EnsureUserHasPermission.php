<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasPermission
{
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(Response::HTTP_FORBIDDEN, 'Izin tidak mencukupi.');
        }

        $hasPermission = collect($permissions)
            ->filter()
            ->contains(fn ($permission) => $user->hasPermission($permission));

        if (! $hasPermission) {
            abort(Response::HTTP_FORBIDDEN, 'Izin tidak mencukupi.');
        }

        return $next($request);
    }
}
