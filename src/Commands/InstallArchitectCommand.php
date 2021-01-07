<?php

namespace JPeters\Architect\Commands;

use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Illuminate\Support\Str;

class InstallArchitectCommand extends Command
{
    public $signature = 'architect:install';

    public $description = 'Install Architect';

    public function handle()
    {
        $this->comment('Publishing Architect Config File');
        $this->callSilent('vendor:publish', ['--tag' => 'architect-config']);

        $this->comment('Publishing Architect Service Provider');
        $this->callSilent('vendor:publish', ['--tag' => 'architect-provider']);
    }

    protected function getAppNamespace(): string
    {
        return Container::getInstance()->getNamespace();
    }

    protected function registerServiceProvider(): void
    {
        $appConfigFile = config_path('app.php');

        file_put_contents($appConfigFile, str_replace(
            "App\\Providers\EventServiceProvider::class".PHP_EOL,
            "App\\Providers\EventServiceProvider::class,".
            PHP_EOL.
            "        App\Providers\ArchitectServiceProvider::class,".PHP_EOL,
            file_get_contents($appConfigFile)
        ));
    }
}
