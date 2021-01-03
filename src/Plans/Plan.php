<?php

namespace JPeters\Architect\Plans;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class Plan
{
    protected string $column;
    protected string $label;
    protected ?Closure $retrievalMethod = null;
    protected ?Closure $retrievalMethodForTable = null;
    protected bool $showInForms = true;
    protected bool $showInTables = true;
    private mixed $defaultValue;

    public function __construct(string $column, ?string $label = null)
    {
        $this->column = $column;

        if (!$label) {
            $label = str_replace('_', ' ', Str::title($column));
        }

        $this->label = $label;
    }

    public static function build(...$params): static
    {
        return new static(...$params);
    }

    public function column(): string
    {
        return $this->column;
    }

    public function currentValue(Model $model): mixed
    {
        if($this->retrievalMethod) {
            return call_user_func($this->retrievalMethod, $model);
        }

        return $model->{$this->column} ?? $this->defaultValue;
    }

    public function currentValueForTable(Model $model): mixed
    {
        if($this->retrievalMethodForTable) {
            return call_user_func($this->retrievalMethodForTable, $model);
        }

        return $this->currentValue($model);
    }

    public function hideInForms(): static
    {
        $this->showInForms = false;

        return $this;
    }

    public function hideInTables(): static
    {
        $this->showInTables = false;

        return $this;
    }

    public function isAvailableOnFormViews()
    {
        return $this->showInForms;
    }

    public function isAvailableOnTableView()
    {
        return $this->showInTables;
    }

    public function label()
    {
        return $this->label;
    }

    public function retreiveCurrentValueUsing(Closure $callable): static
    {
        $this->retrievalMethod = $callable;

        return $this;
    }

    public function retreiveCurrentValueForTableUsing(Closure $callable): static
    {
        $this->retrievalMethodForTable = $callable;

        return $this;
    }

    public function useDefaultValue(mixed $value): static
    {
        $this->defaultValue = $value;

        return $this;
    }
}
