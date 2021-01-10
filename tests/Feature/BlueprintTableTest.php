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
    public function it_shows_the_search_box_if_the_blueprint_is_searchable()
    {
        Livewire::test(Table::class, ['route' => 'blog'])
            ->assertSee('Search...')
            ->assertSeeHtml('<i class="fas fa-search"></i>')
            ->set('settings.searchable', false)
            ->assertDontSee('Search...');
    }

    /** @test */
    public function it_shows_the_add_button_if_the_the_blueprint_is_addable()
    {
        $this->withoutExceptionHandling();

        Livewire::test(Table::class, ['route' => 'blog'])
            ->assertSee('Add New')
            ->set('settings.canAdd', false)
            ->assertDontSee('Add New');
    }

    /** @test */
    public function it_shows_the_table_colums()
    {
        $request = Livewire::test(Table::class, ['route' => 'blog']);

        foreach ($this->tableRenderer->headers() as $header) {
            $request->assertSee($header);
        }
    }

    /** @test */
    public function it_shows_the_model_data()
    {
        $blog = factory(Blog::class)->create();

        $request = Livewire::test(Table::class, ['route' => 'blog']);

        foreach ($this->tableRenderer->columns() as $column) {
            $request->assertSee($blog->$column);
        }
    }

    /** @test */
    public function it_can_search_for_data()
    {
        factory(Blog::class)->create(['title' => 'hidden blog']);
        factory(Blog::class)->create(['title' => 'foo blog']);

        Livewire::test(Table::class, ['route' => 'blog'])
            ->assertSee('hidden blog')
            ->assertSee('foo blog')
            ->set('searchText', 'foo blog')
            ->call('runSearch')
            ->assertDontSee('hidden blog')
            ->assertSee('foo blog');
    }

    /** @test */
    public function it_can_paginate_data()
    {
        factory(Blog::class)->create(['title' => 'First Blog']);
        factory(Blog::class)->create(['title' => 'Second Blog']);
        factory(Blog::class)->create(['title' => 'Third Blog']);

        Livewire::test(Table::class, ['route' => 'blog'])
            ->assertSee('First Blog')
            ->assertSee('Second Blog')
            ->assertDontSee('Third Blog')
            ->assertSee('Previous')
            ->assertSee('Next')
            ->call('setPage', 2)
            ->assertSee('Third Blog')
            ->assertDontSee('First Blog');
    }
}
