<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Vérifier que l'utilisateur est bien un User (pas un Admin)
        if (!$user instanceof User) {
            return response()->json(['message' => 'Forbidden - User access required'], 403);
        }

        return $next($request);
    }
}
