<?php

namespace App\Http\Middleware\Statamic;

use Closure;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Facades\Auth;
use Statamic\Exceptions\AuthenticationException;
use Statamic\Exceptions\AuthorizationException;

class PermissionMiddleware extends Authorize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $ability
     * @param  array|null  ...$models
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function handle($request, Closure $next, $ability, ...$models)
    {
        if (Auth::guest()) {
            throw new AuthenticationException('Unauthenticated.');
        }

        $permissions = is_array($ability) ? $ability : explode('|', $ability);

        // Allow Super User
        if (Auth::user()->isSuper()) {
            foreach ($permissions as $permission) {
                $this->gate->authorize($permission, $this->getGateArguments($request, $models));
            }

            return $next($request);
        }

        $userDoesNotHaveMatchingpermission = true;
        foreach ($permissions as $permission) {
            if (Auth::user()->hasPermission($permission)) {
                $this->gate->authorize($permission, $this->getGateArguments($request, $models));
                $userDoesNotHaveMatchingpermission = false;
                break;
            }
        }

        if ($userDoesNotHaveMatchingpermission) {
            foreach ($permissions as $permission) {
                $this->gate->authorize($permission, $this->getGateArguments($request, $models));
            }

            // dd('theres a user but they are unauthorized', Auth::user());
            throw new AuthorizationException('Unauthorized.');
        }

        return $next($request);
    }
}
