<?php

namespace JPeters\Architect\Tests\Laravel\Providers;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class TestingServiceProvider extends ServiceProvider
{
    public function register()
    {
        Config::set('app.key', Str::random(32));
    }
}
