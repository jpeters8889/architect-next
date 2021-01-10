<?php

namespace JPeters\Architect\Tests\Plans;

use Illuminate\Database\Eloquent\Model;
use JPeters\Architect\Plans\BaseTableComponent;
use JPeters\Architect\Plans\Plan;
use JPeters\Architect\Tests\ArchitectTestCase;
use JPeters\Architect\Tests\Laravel\Models\Blog;

abstract class PlanTestCase extends ArchitectTestCase
{
    abstract protected function planClass(): string;

    /** @test */
    public function it_sets_the_column_name()
    {
        $class = $this->planClass();

        /** @var Plan $plan */
        $plan = new $class('foo');

        $this->assertEquals('foo', $plan->column());
    }

    /** @test */
    public function it_sets_the_label_automatically()
    {
        $class = $this->planClass();

        /** @var Plan $plan */
        $plan = new $class('foo_bar');

        $this->assertEquals('Foo Bar', $plan->label());
    }

    /** @test */
    public function it_uses_the_passed_label_if_present()
    {
        $class = $this->planClass();

        /** @var Plan $plan */
        $plan = new $class('foo', 'bar');

        $this->assertEquals('bar', $plan->label());
    }

    /** @test */
    public function it_can_be_constructed_using_a_static_builder()
    {
        $plan = $this->planClass()::build('foo', 'bar');

        $this->assertInstanceOf($this->planClass(), $plan);
        $this->assertEquals('bar', $plan->label());
    }

    /** @test */
    public function it_can_be_hidden_on_the_table_view()
    {
        $plan = $this->buildPlan();

        $this->assertTrue($plan->isAvailableOnTableView());

        $plan->hideInTables();

        $this->assertFalse($plan->isAvailableOnTableView());
    }

    /** @test */
    public function it_can_be_hidden_on_the_form_views()
    {
        $plan = $this->buildPlan();

        $this->assertTrue($plan->isAvailableOnFormViews());

        $plan->hideInForms();

        $this->assertFalse($plan->isAvailableOnFormViews());
    }

    /** @test */
    public function it_can_get_the_current_value()
    {
        $blog = factory(Blog::class)->create(['title' => 'Foobar']);

        $plan = $this->buildPlan('title');

        $this->assertEquals('Foobar', $plan->currentValue($blog));
    }

    /** @test */
    public function it_can_pass_a_closure_to_get_the_current_value()
    {
        $blog = factory(Blog::class)->create(['title' => 'Foo']);

        $plan = $this->buildPlan('title');

        $plan->retreiveCurrentValueUsing(function (Model $model) {
            return $model->title . ' Bar';
        });

        $this->assertEquals('Foo Bar', $plan->currentValue($blog));
    }

    /** @test */
    public function it_can_pass_a_closure_to_get_the_current_value_for_the_table()
    {
        $blog = factory(Blog::class)->create(['title' => 'Foo']);

        $plan = $this->buildPlan('title');

        $plan->retreiveCurrentValueForTableUsing(function (Model $model) {
            return $model->title . ' Bar';
        });

        $this->assertEquals('Foo Bar', $plan->currentValueForTable($blog));
        $this->assertEquals('Foo', $plan->currentValue($blog));
    }

    /** @test */
    public function it_can_have_a_default_value()
    {
        $blog = factory(Blog::class)->create();

        $plan = $this->buildPlan();

        $plan->useDefaultValue('bar');

        $this->assertEquals('bar', $plan->currentValue($blog));
    }

    /** @test */
    public function it_returns_a_livewire_view_for_the_table()
    {
        $class = $this->buildPlan()->tableComponent();

        $component = new $class();

        $this->assertInstanceOf(BaseTableComponent::class, $component);
    }

    protected function buildPlan(string $column = 'foo', ?string $label = null): Plan
    {
        return $this->planClass()::build($column, $label);
    }
}
