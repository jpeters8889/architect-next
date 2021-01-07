<?php

namespace JPeters\Architect\Blueprints;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class Blueprint
{
    public function blueprintName(): string
    {
        return Str::plural(Str::title(class_basename($this->model())));
    }

    public function blueprintRoute(): string
    {
        return Str::slug(class_basename($this->model()));
    }

    public function blueprintBuilding(): string
    {
        return 'Main';
    }

    public function canAdd(Authenticatable $user): bool
    {
        return true;
    }

    public function canEdit(Model $model, Authenticatable $user): bool
    {
        return true;
    }

    public function displayCount(): int
    {
        return 0;
    }

    public function getData(): Builder
    {
        return $this->model()::query();
    }

    abstract public function model(): string;

    public function ordering(): array
    {
        return [
            'created_at',
            'desc',
        ];
    }

    public function paginate(): bool
    {
        return true;
    }

    public function perPage(): int
    {
        return 25;
    }

    abstract public function plans(): array;

    public function searchable(): bool
    {
        return true;
    }
}
