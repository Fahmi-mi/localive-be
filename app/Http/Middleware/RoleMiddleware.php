<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Restrict access to Super Admin only.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user() || $request->user()->role !== $role) {
            return response()->json([
                'message' => 'Akses ditolak. Anda tidak memiliki izin.',
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
