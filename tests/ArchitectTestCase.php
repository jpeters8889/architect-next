<?php

namespace JPeters\Architect\Tests;

use Illuminate\Foundation\Application;
use JPeters\Architect\Architect;
use JPeters\Architect\Providers\ArchitectApplicationServiceProvider;
use JPeters\Architect\Providers\ArchitectCoreServiceProvider;
use JPeters\Architect\Tests\Laravel\Models\User;
use JPeters\Architect\Tests\Laravel\Providers\TestingServiceProvider;
use Orchestra\Testbench\TestCase;

class ArchitectTestCase extends TestCase
{
    /** @var Architect */
    protected $architect;

    /** @var Application */
    protected $app;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrations();

        $this->withFactories(__DIR__ . '/Laravel/Factories');

        $this->architect = resolve(Architect::class);
    }

    protected function loadMigrations()
    {
        $this->artisan('migrate')->run();

        $this->loadMigrationsFrom([
            '--database' => 'sqlite',
            '--path' => realpath(__DIR__ . '/Laravel/Migrations'),
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            ArchitectCoreServiceProvider::class,
            ArchitectApplicationServiceProvider::class,
            TestingServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set(['auth.providers.users.model' => User::class]);

        $app['config']->set('database.default', 'sqlite');

        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}
