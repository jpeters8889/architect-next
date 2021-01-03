<?php

namespace JPeters\Architect\Http\Livewire\Blueprints;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use JPeters\Architect\Blueprints\Blueprint;
use JPeters\Architect\Blueprints\Manager;
use JPeters\Architect\Blueprints\TableRenderer;
use JPeters\Architect\Http\Requests\BlueprintRequest;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public string $route = '';
    private array $blueprintData = [];
    private Blueprint $blueprint;

    public function mount(): void
    {
        /** @var Manager $manager */
        $manager = resolve(Manager::class);

        $this->blueprint = $manager->resolve($this->route);
        $this->blueprintData = (new TableRenderer($this->blueprint))->render();
    }

    public function render(): View
    {
        return view('architect::livewire.blueprints.table', [
            'title' => $this->blueprint->blueprintName(),
            'headers' => $this->blueprintData['headers'],
            'columns' => $this->blueprintData['columns'],
            'data' => $this->getBlueprintData(),
        ]);
    }

    protected function getBlueprintData(): Collection|LengthAwarePaginator
    {
        if ($this->blueprint->paginate()) {
            return $this->blueprintData['data']->paginate($this->blueprint->perPage());
        }

        return $this->blueprintData['data']->get();
    }
}
