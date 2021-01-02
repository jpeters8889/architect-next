<?php

namespace JPeters\Architect\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class Authorise
{
    public function handle(Request $request, \Closure $next)
    {
        if (!Gate::check('accessArchitect', [$request->user()])) {
            abort(403);
        }

        return $next($request);
    }
}
