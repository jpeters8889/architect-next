<?php

namespace JPeters\Architect\Tests\Unit;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use JPeters\Architect\Blueprints\TableRenderer;
use JPeters\Architect\Plans\Plan;
use JPeters\Architect\Tests\ArchitectTestCase;
use JPeters\Architect\Tests\Laravel\Blueprints\Blog as BlogBlueprint;
use JPeters\Architect\Tests\Laravel\Models\Blog;

class BlueprintTableRendererTest extends ArchitectTestCase
{
    private BlogBlueprint $blueprint;
    private TableRenderer $tableRenderer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->blueprint = new BlogBlueprint();
        $this->tableRenderer = new TableRenderer($this->blueprint);
    }

    /** @test */
    public function it_returns_the_blueprints_plans()
    {
        $this->assertInstanceOf(Collection::class, $this->tableRenderer->plans());
    }

    /** @test */
    public function it_returns_the_plans_in_the_correct_format()
    {
        $this->tableRenderer->plans()->each(function ($plan) {
            foreach (['column', 'index'] as $key) {
                $this->assertArrayHasKey($key, $plan);
            }
        });
    }

    /** @test */
    public function it_returns_the_appropiate_column_names_from_the_blueprint()
    {
        collect($this->blueprint->plans())
            ->filter(fn(Plan $plan) => $plan->isAvailableOnTableView())
            ->each(function (Plan $plan) {
//                dd($plan);
            });
    }

    /** @test */
    public function it_returns_the_appropiate_headers_from_the_blueprint()
    {
        collect($this->blueprint->plans())
            ->filter(fn(Plan $plan) => $plan->isAvailableOnTableView())
            ->map(fn(Plan $plan) => $plan->label())
            ->each(fn($header) => $this->assertContains($header, $this->tableRenderer->headers()));
    }

    /** @test */
    public function it_returns_the_data_as_a_query_builder_instance_for_the_table()
    {
        $this->assertInstanceOf(Builder::class, $this->tableRenderer->data());
    }

    /** @test */
    public function it_returns_the_correct_data()
    {
        factory(Blog::class, 15)->create();

        $data = $this->tableRenderer->data()->get();

        $this->assertCount(15, $data);
    }

    /** @test */
    public function it_returns_data_in_the_correct_order()
    {
        factory(Blog::class)->create(['title' => 'Second']);
        factory(Blog::class)->create(['title' => 'Third', 'created_at' => Carbon::now()->subDay()]);
        factory(Blog::class)->create(['title' => 'First', 'created_at' => Carbon::now()->addHour()]);

        $data = $this->tableRenderer->data()->get();

        $this->assertEquals('First', $data[0]->title);
        $this->assertEquals('Second', $data[1]->title);
        $this->assertEquals('Third', $data[2]->title);
    }
}
