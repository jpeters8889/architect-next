<?php

namespace JPeters\Architect\Blueprints;

use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Plans\Plan;

class TableRenderer
{
    private Blueprint $blueprint;

    public function __construct(Blueprint $blueprint)
    {
        $this->blueprint = $blueprint;
    }

    public function render(): array
    {
        return [
            'headers' => $this->tableHeaders(),
            'columns' => $this->modelColumns(),
            'data' => $this->tableData(),
        ];
    }

    private function tableHeaders(): iterable
    {
        return collect($this->blueprint->plans())
            ->filter(fn(Plan $plan) => $plan->isAvailableOnTableView())
            ->map(fn(Plan $plan) => $plan->label())
            ->values();
    }

    private function modelColumns(): iterable
    {
        return collect($this->blueprint->plans())
            ->filter(fn(Plan $plan) => $plan->isAvailableOnTableView())
            ->map(fn(Plan $plan) => $plan->column())
            ->values();
    }

    private function tableData(): Builder
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
