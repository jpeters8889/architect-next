<?php

declare(strict_types=1);

namespace JPeters\Architect\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JPeters\Architect\Events\ArchitectRunning;

class ArchitectIsRunning
{
    public function handle(Request $request, Closure $next)
    {
        ArchitectRunning::dispatch($request);

        return $next($request);
    }
}
