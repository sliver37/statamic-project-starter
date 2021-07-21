<?php

namespace App\Http\Middleware\Statamic;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Statamic\Exceptions\AuthenticationException;
use Statamic\Exceptions\AuthorizationException;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::guest()) {
            throw new AuthenticationException('Unauthenticated.');
        }

        // Allow Super User
        if (Auth::user()->isSuper()) {
            return $next($request);
        }

        $roles = is_array($role) ? $role : explode('|', $role);
        $usersRoles = Auth::user()->roles();

        $userDoesNotHaveMatchingRole = true;
        foreach ($roles as $role) {
            if ($usersRoles->has($role)) {
                $userDoesNotHaveMatchingRole = false;
                break;
            }
        }

        if ($userDoesNotHaveMatchingRole) {
            // dd('theres a user but they are unauthorized', Auth::user());
            throw new AuthorizationException('Unauthorized.');
        }

        return $next($request);
    }
}
