<?php

namespace JPeters\Architect\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as BaseAuthenticationMiddleware;
use JPeters\Architect\Architect;

class Authenticate extends BaseAuthenticationMiddleware
{

    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $guard = config('architect.auth.guard');

            if (! empty($guard)) {
                $guards[] = $guard;
            }

            return parent::handle($request, $next, ...$guards);
        } catch (AuthenticationException $e) {
            if ($url = config('architect.auth.unauthenticated_url')) {
                return redirect($url);
            }

            abort(403);
        }
    }
}
