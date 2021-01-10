<?php

declare(strict_types=1);

namespace JPeters\Architect\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use JPeters\Architect\Architect;
use JPeters\Architect\Blueprints\Manager;
use Livewire\Livewire;

class ArchitectApplicationServiceProvider extends ServiceProvider
{
    protected Architect $architect;

    public function boot()
    {
        $this->bootArchitectLibraries();
        $this->defineArchitectGateway();
        $this->registerBlueprints();
        $this->bootPlanLivewireComponents();

        $this->app->singleton(Architect::class, fn() => $this->architect);
    }

    private function bootArchitectLibraries(): void
    {
        $this->architect = new Architect();

        $this->app->singleton(Manager::class, fn() => new Manager());
    }

    protected function blueprints(): array
    {
        return [];
    }

    private function registerBlueprints(): void
    {
        (new Collection($this->blueprints()))->map(function ($blueprint) {
            $this->architect->registerBlueprint($blueprint);
        });
    }

    protected function architectGateway($user): bool
    {
        return config('app.env') === 'local';
    }

    protected function defineArchitectGateway(): void
    {
        Gate::define('accessArchitect',
            function ($user) {
                return $this->architectGateway($user);
            }
        );
    }

    protected function bootPlanLivewireComponents(): void
    {
        /** @var Filesystem $filesystem */
        $filesystem = $this->app->make(Filesystem::class);
        collect($filesystem->directories(__DIR__.'/../Plans'))
            ->map(function ($directory) {
                $plan = Arr::last(explode('/', $directory));
                $namespace = 'JPeters\\Architect\\Plans\\';
                $alias = 'architect-plan-'.(Str::kebab($plan));

                Livewire::component($alias.'-table', $namespace.$plan.'\\TableComponent');
            });
    }
}
