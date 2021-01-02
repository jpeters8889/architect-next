<?php

namespace JPeters\Architect\Tests\Unit;

use JPeters\Architect\Blueprints\Manager as BlueprintManager;
use JPeters\Architect\Tests\ArchitectTestCase;
use JPeters\Architect\Tests\Laravel\Blueprints\Blog as BlogBlueprint;

class BlueprintManagerTest extends ArchitectTestCase
{
    /** @test */
    public function it_can_resolve_the_blueprint_manager_from_the_container()
    {
        $this->assertInstanceOf(BlueprintManager::class, resolve(BlueprintManager::class));
    }

    /** @test */
    public function it_can_register_blueprints()
    {
        /** @var BlueprintManager $blueprintManager */
        $blueprintManager = resolve(BlueprintManager::class);

        $this->assertCount(0, $blueprintManager->list());

        $blueprintManager->register('foo');

        $this->assertCount(1, $blueprintManager->list());
    }

    /** @test */
    public function it_resolves_the_blueprint_manager_as_a_singleton()
    {
        /** @var BlueprintManager $blueprintManager */
        $blueprintManager = resolve(BlueprintManager::class);

        $blueprintManager->register('foo');

        $this->assertSame(resolve(BlueprintManager::class), $blueprintManager);
    }

    /** @test */
    public function it_can_resolve_a_blueprint()
    {
        /** @var BlueprintManager $manager */
        $manager = resolve(BlueprintManager::class);
        $manager->register(BlogBlueprint::class);

        $this->assertInstanceOf(BlogBlueprint::class, $manager->resolve('blog'));
    }
}
