<?php

namespace JPeters\Architect\Blueprints;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use JPeters\Architect\Plans\Plan;

class TableRenderer
{
    private Blueprint $blueprint;

    public function __construct(Blueprint $blueprint)
    {
        $this->blueprint = $blueprint;
    }

    public function headers(): Collection
    {
        return collect($this->blueprint->plans())
            ->filter(fn(Plan $plan) => $plan->isAvailableOnTableView())
            ->map(fn(Plan $plan) => $plan->label())
            ->values();
    }

    public function plans(): Collection
    {
        return collect($this->blueprint->plans())
            ->transform(fn(Plan $plan, int $index) => [
                'plan' => $plan,
                'index' => $index,
                'column' => $plan->column(),
                'component' => 'architect-plan-'.Str::kebab(class_basename($plan)).'-table',
            ])
            ->filter(fn($plan) => $plan['plan']->isAvailableOnTableView())
            ->values();
    }

    public function data(): Builder
    {
        $data = $this->blueprint->getData();

        $this->orderEloquentBuilder($data);

        return $data;
    }

    private function orderEloquentBuilder(Builder $data): void
    {
        $ordering = $this->blueprint->ordering();

        if (!is_array($ordering[0])) {
            $ordering = [$ordering];
        }

        foreach ($ordering as $order) {
            $data->orderBy(...$order);
        }
    }
}
