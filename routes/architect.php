<?php

use Illuminate\Routing\Router;
use JPeters\Architect\Http\Controllers\ArchitectController;
use JPeters\Architect\Http\Controllers\BlueprintController;

/* @var Router $router */

$router->get('/', ArchitectController::class);

$router->group(['prefix' => 'blueprints/{blueprint}'], function (Router $router) {
    $router->get('/', [BlueprintController::class, 'index']);
});
