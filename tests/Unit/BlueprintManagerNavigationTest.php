<?php

namespace JPeters\Architect\Tests\Unit;

use JPeters\Architect\Blueprints\Manager as BlueprintManager;
use JPeters\Architect\Blueprints\Navigator;
use JPeters\Architect\Tests\ArchitectTestCase;
use JPeters\Architect\Tests\Laravel\Blueprints\Blog as BlogBlueprint;
use JPeters\Architect\Tests\Laravel\Blueprints\User as UserBlueprint;

class BlueprintManagerNavigationTest extends ArchitectTestCase
{
    private BlueprintManager $manager;
    private Navigator $navigator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->manager = resolve(BlueprintManager::class);
        $this->navigator = new Navigator($this->manager);

        $this->manager->register(BlogBlueprint::class); // in main building
        $this->manager->register(UserBlueprint::class); // in foo bar building
    }

    /** @test */
    public function it_can_render_the_navigation()
    {
        $this->assertIsArray($this->navigator->render());
    }

    /** @test */
    public function it_returns_the_correct_keys()
    {
        foreach (['dashboards', 'buildings'] as $key) {
            $this->assertArrayHasKey($key, $this->navigator->render());
        }
    }

    /** @test */
    public function it_lists_two_buildings()
    {
        $this->assertCount(2, $this->navigator->render()['buildings']);
    }

    /** @test */
    public function it_returns_the_buildings_as_an_array_with_a_label_and_item_keys()
    {
        $buildings = $this->navigator->render()['buildings'];

        foreach ($buildings as $building) {
            $this->assertArrayHasKey('label', $building);
            $this->assertArrayHasKey('items', $building);
        }
    }

    /** @test */
    public function it_has_the_buidlings_loaded_into_the_blueprint_manager()
    {
        $buildings = array_map(fn($item) => $item['label'], $this->navigator->render()['buildings']);

        foreach (['Main', 'Foo Bar'] as $building) {
            $this->assertContains($building, $buildings);
        }
    }

    /** @test */
    public function it_returns_an_array_of_items()
    {
        foreach ($this->navigator->render()['buildings'] as $building) {
            $this->assertIsArray($building['items']);
        }
    }

    /** @test */
    public function it_has_one_item_in_each_buidling()
    {
        foreach ($this->navigator->render()['buildings'] as $building) {
            $this->assertCount(1, $building['items']);
        }
    }

    /** @test */
    public function it_has_the_correct_keys_in_each_building_item()
    {
        foreach ($this->navigator->render()['buildings'] as $building) {
            foreach ($building['items'] as $item) {
                foreach (['label', 'url'] as $key) {
                    $this->assertArrayHasKey($key, $item);
                }
            }
        }
    }

    /** @test */
    public function it_has_the_correct_data_for_each_blueprint()
    {
        $buidlings = $this->navigator->render()['buildings'];

        $blogs = array_values(array_filter($buidlings, fn($building) => $building['label'] === 'Main'))[0]['items'][0];
        $users = array_values(array_filter($buidlings, fn($building) => $building['label'] === 'Foo Bar'))[0]['items'][0];

        $this->assertEquals('Blogs', $blogs['label']);
        $this->assertEquals('/admin/blueprints/blog', $blogs['url']);

        $this->assertEquals('Users', $users['label']);
        $this->assertEquals('/admin/blueprints/user', $users['url']);
    }
}
