<?php

namespace JPeters\Architect\Providers;

use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use JPeters\Architect\Commands\InstallArchitectCommand;
use JPeters\Architect\Http\Views\NavigationComposer;

class ArchitectCoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishCommands();
            $this->registerConsoleCommands();
        }

        $this->registerViews();
        $this->registerViewComposers();
        $this->registerRoutes();
        $this->registerMacros();
    }

    protected function registerConsoleCommands()
    {
        $this->commands([
            InstallArchitectCommand::class,
        ]);
    }

    public function register()
    {
        if (!$this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__ . '/../../config/architect.php', 'architect');
        }
    }

    protected function registerRoutes(): void
    {
        $router = Container::getInstance()->make(Router::class);
        $config = Container::getInstance()->make(ConfigRepository::class);

        $router->group(
            [
                'prefix' => $config->get('architect.route'),
                'middleware' => $config->get('architect.auth.middleware'),
            ],
            function ($router) {
                require __DIR__ . '/../../routes/architect.php';
            }
        );
    }

    protected function registerPublishCommands(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/architect.php' => config_path('architect.php'),
        ], 'architect-config');

        $this->publishes([
            __DIR__ . '/../Commands/Stubs/ArchitectServiceProvider.stub' => app_path('Providers/ArchitectServiceProvider.php'),
        ], 'architect-provider');
    }

    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'architect');
    }

    protected function registerViewComposers(): void
    {
        View::composer('architect::*', NavigationComposer::class);
    }

    protected function registerMacros(): void
    {
//        Request::macro('architectActivePage', function() {
//
//        });
    }
}
