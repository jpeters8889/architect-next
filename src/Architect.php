<?php

namespace JPeters\Architect;

use Closure;
use Illuminate\Contracts\Events\Dispatcher;
use JPeters\Architect\Blueprints\Manager as BlueprintManager;
use JPeters\Architect\Events\ArchitectRunning;

class Architect
{
    public static function isRunning(Closure $callback): void
    {
        resolve(Dispatcher::class)->listen(ArchitectRunning::class, $callback);
    }

    public function registerBlueprint(string $blueprint): void
    {
        resolve(BlueprintManager::class)->register($blueprint);
    }

    public static function createUrl($path): string
    {
        $url = config('architect.route') . '/'. rtrim($path, '/');

        return '/'.rtrim($url, '/');
    }
}
