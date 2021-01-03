<?php

namespace JPeters\Architect\Tests\Feature;

use JPeters\Architect\Blueprints\Manager;
use JPeters\Architect\Blueprints\TableRenderer;
use JPeters\Architect\Http\Livewire\Blueprints\Table;
use JPeters\Architect\Tests\ArchitectTestCase;
use JPeters\Architect\Tests\Laravel\Blueprints\Blog as BlogBlueprint;
use JPeters\Architect\Tests\Laravel\Models\Blog;
use Livewire\Livewire;

class BlueprintTableTest extends ArchitectTestCase
{
    private BlogBlueprint $blueprint;
    private TableRenderer $tableRenderer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->blueprint = new BlogBlueprint();

        resolve(Manager::class)->register($this->blueprint::class);

        $this->tableRenderer = new TableRenderer($this->blueprint);

        $this->login();
    }

    /** @test */
    public function it_returns_404_if_the_blueprint_doesnt_exist()
    {
        $this->get('/admin/blueprints/foobar')->assertNotFound();
    }

    /** @test */
    public function it_returns_a_success()
    {
        $this->get('/admin/blueprints/blog')->assertOk();
    }

    /** @test */
    public function it_shows_the_blueprint_title()
    {
        Livewire::test(Table::class, ['route' => 'blog'])
            ->assertSee($this->blueprint->blueprintName());
    }

    /** @test */
    public function it_shows_the_table_colums()
    {
        $request = Livewire::test(Table::class, ['route' => 'blog']);

        foreach ($this->tableRenderer->render()['headers'] as $header) {
            $request->assertSee($header);
        }
    }

    /** @test */
    public function it_shows_the_model_data()
    {
        $blog = factory(Blog::class)->create();

        $request = Livewire::test(Table::class, ['route' => 'blog']);

        foreach ($this->tableRenderer->render()['columns'] as $column) {
            $request->assertSee($blog->$column);
        }
    }
}
