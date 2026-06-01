<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $this->resolveUser($request);

        if (! $user) {
            abort(401, 'Unauthenticated.');
        }

        $userRoles = $user->roles()->pluck('name')->map(fn (string $role) => strtolower(trim($role)))->all();
        $requiredRoles = array_map(fn (string $role) => strtolower(trim($role)), $roles);

        $allowed = ! empty($requiredRoles)
            ? count(array_intersect($requiredRoles, $userRoles)) > 0
            : false;

        if (! $allowed) {
            abort(403, 'Forbidden: insufficient role permissions.');
        }

        return $next($request);
    }

    private function resolveUser(Request $request): ?User
    {
        if (! $request->is('api/*')) {
            return $request->user();
        }

        $token = $request->bearerToken();

        if (! $token) {
            return null;
        }

        $accessToken = PersonalAccessToken::findToken($token);
        $user = $accessToken?->tokenable;

        if (! $user instanceof User) {
            return null;
        }

        $user->withAccessToken($accessToken);
        $request->setUserResolver(fn () => $user);
        Auth::setUser($user);

        return $user;
    }
}
