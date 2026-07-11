<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(401, 'Unauthenticated.');
        }

        // Resolve user role
        $userRole = UserRole::tryFrom($user->role);

        // Check if user's role matches any of the allowed roles
        foreach ($roles as $role) {
            if ($userRole === UserRole::tryFrom($role)) {
                return $next($request);
            }
        }

        abort(403, 'Akses ditolak: Anda tidak memiliki wewenang untuk aksi ini.');
    }
}
