<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleCheckMiddleware
{
    public function handle(Request $request, Closure $next, ...$role): mixed
    {
        $roleUser = auth('sanctum')->user();
        $roleUser = is_null($roleUser) ? '' : $roleUser->role;

        if (in_array($roleUser, $role)) {
            return $next($request);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Kamu tidak memiliki akses untuk mengakses halaman ini'
        ], 403);
    }
}
