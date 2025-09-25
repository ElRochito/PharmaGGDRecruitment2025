<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsurePermission
{
    /**
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next, string $permissionCode): Response
    {
        /** @var Admin $admin */
        $admin = Auth::guard('sanctum')->user();

        if ($admin === null) {
            abort(401, 'Unauthenticated.');
        }

        if ($admin->role->all_permissions) {
            return $next($request);
        }

        $hasPermission = $admin->role->permissions->contains('code', $permissionCode);

        if (!$hasPermission) {
            abort(403, 'Unauthorized: You do not have the required permission.');
        }

        return $next($request);
    }
}
