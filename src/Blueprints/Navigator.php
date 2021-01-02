<?php

namespace JPeters\Architect\Blueprints;

use JPeters\Architect\Architect;

class Navigator
{
    private Manager $blueprintManager;

    public function __construct(Manager $blueprintManager)
    {
        $this->blueprintManager = $blueprintManager;
    }

    public function render(): array
    {
        return [
            'dashboards' => [],
            'buildings' => $this->getBlueprintBuildings(),
        ];
    }

    protected function getBlueprintBuildings(): array
    {
        return $this->blueprintManager
            ->list()
            ->map(fn($blueprint) => (new $blueprint())->blueprintBuilding())
            ->unique()
            ->transform(fn($building) => [
                'label' => $building,
                'items' => $this->getBlueprintsInBuilding($building),
            ])
            ->toArray();
    }

    protected function getBlueprintsInBuilding(string $building): array
    {
        return $this->blueprintManager
            ->list()
            ->map(fn($blueprint) => new $blueprint())
            ->filter(fn(Blueprint $blueprint) => $blueprint->blueprintBuilding() === $building)
            ->transform(fn(Blueprint $blueprint) => [
                'label' => $blueprint->blueprintName(),
                'url' => Architect::createUrl("blueprints/{$blueprint->blueprintRoute()}"),
            ])
            ->values()
            ->toArray();
    }
}
