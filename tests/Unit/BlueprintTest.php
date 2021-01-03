<?php

namespace JPeters\Architect\Tests\Unit;

use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Tests\ArchitectTestCase;
use JPeters\Architect\Tests\Laravel\Blueprints\Blog as BlogBlueprint;
use JPeters\Architect\Tests\Laravel\Models\Blog as BlogModel;

class BlueprintTest extends ArchitectTestCase
{
    private BlogBlueprint $blogBlueprint;

    protected function setUp(): void
    {
        parent::setUp();

        $this->blogBlueprint = new BlogBlueprint();
    }

    /** @test */
    public function it_computes_a_name_for_the_blueprint_from_the_model()
    {
        $this->assertEquals('Blogs', $this->blogBlueprint->blueprintName());
    }

    /** @test */
    public function it_computes_a_route_for_the_blueprint_from_the_model()
    {
        $this->assertEquals('blog', $this->blogBlueprint->blueprintRoute());
    }

    /** @test */
    public function it_is_placed_in_the_main_building_by_default()
    {
        $this->assertEquals('Main', $this->blogBlueprint->blueprintBuilding());
    }

    /** @test */
    public function it_can_return_a_count_for_the_sidebar()
    {
        $this->assertEquals(0, $this->blogBlueprint->displayCount());

        factory(BlogModel::class)->create();

        $this->assertEquals(1, $this->blogBlueprint->displayCount());
    }

    /** @test */
    public function it_can_get_data_from_the_model()
    {
        $this->assertInstanceOf(Builder::class, $this->blogBlueprint->getData());
    }

    /** @test */
    public function it_returns_an_array_with_query_ordering_instructions()
    {
        $this->assertIsArray($this->blogBlueprint->ordering());
    }

    /** @test */
    public function it_returns_whether_the_blueprint_should_be_paginated()
    {
        $this->assertIsBool($this->blogBlueprint->paginate());
    }

    /** @test */
    public function it_returns_the_number_of_rows_per_page()
    {
        $this->assertIsInt($this->blogBlueprint->perPage());
    }

    /** @test */
    public function it_knows_whether_it_is_searchable()
    {
        $this->assertIsBool($this->blogBlueprint->searchable());
    }
}
