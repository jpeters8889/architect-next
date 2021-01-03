<?php

namespace JPeters\Architect\Blueprints;

use Illuminate\Support\Collection;
use JPeters\Architect\Exceptions\BlueprintNotFoundException;

class Manager
{
    protected Collection $blueprints;

    public function __construct()
    {
        $this->blueprints = new Collection();
    }

    public function list(): Collection
    {
        return $this->blueprints;
    }

    public function register(string $blueprint): void
    {
        $this->blueprints->push($blueprint);
    }

    public function resolve(string $key): Blueprint
    {
        $resolved = $this->blueprints->filter(function (string $blueprint) use ($key) {
            /** @var Blueprint $concreteBlueprint */
            $concreteBlueprint = new $blueprint();

            return $concreteBlueprint->blueprintRoute() === $key;
        })->first();

        throw_if(!$resolved, new BlueprintNotFoundException());

        return new $resolved();
    }
}
