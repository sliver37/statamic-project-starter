<?php

namespace App\Http\Middleware\Statamic;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Statamic\Exceptions\AuthenticationException;
use Statamic\Exceptions\AuthorizationException;

class GroupMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $group)
    {
        if (Auth::guest()) {
            throw new AuthenticationException('Unauthenticated.');
        }

        // Allow Super User
        if (Auth::user()->isSuper()) {
            return $next($request);
        }

        $groups = is_array($group) ? $group : explode('|', $group);
        $usersGroups = Auth::user()->groups();

        $userDoesNotHaveMatchingGroup = true;
        foreach ($groups as $group) {
            if ($usersGroups->has($group)) {
                $userDoesNotHaveMatchingGroup = false;
                break;
            }
        }

        if ($userDoesNotHaveMatchingGroup) {
            // dd('theres a user but they are unauthorized', Auth::user());
            throw new AuthorizationException('Unauthorized.');
        }

        return $next($request);
    }
}
