<?php

namespace JPeters\Architect\Http\Livewire\Blueprints;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use JPeters\Architect\Blueprints\Blueprint;
use JPeters\Architect\Blueprints\Manager;
use JPeters\Architect\Blueprints\TableRenderer;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public string $route = '';
    public bool $searchable = true;
    public string $searchText = '';

    private Collection|LengthAwarePaginator $data;
    private bool $hasBootstrapped = false;
    private array $blueprintData = [];
    private ?Blueprint $blueprint = null;

    public function mount(): void
    {
        $this->bootstrap();
    }

    public function hydrate(): void
    {
        $this->bootstrap();
    }

    public function render(): View
    {
        return view('architect::livewire.blueprints.table', [
            'title' => $this->blueprint->blueprintName(),
            'headers' => $this->blueprintData['headers'],
            'columns' => $this->blueprintData['columns'],
        ]);
    }

    public function getDataProperty()
    {
        return $this->data;
    }

    public function runSearch()
    {
        if ($this->blueprint->paginate()) {
            $this->resetPage();
        }

        $data = $this->blueprintData['data'];

        foreach($this->blueprintData['columns'] as $column) {
            $data->where($column, 'LIKE', "%{$this->searchText}%");
        }

        $this->data = $this->getBlueprintData($data);
    }

    protected function getBlueprintData(?Builder $builder = null): Collection|LengthAwarePaginator
    {
        if (!$builder) {
            $builder = $this->blueprintData['data'];
        }

        if ($this->blueprint->paginate()) {
            return $builder->paginate($this->blueprint->perPage());
        }

        return $builder->get();
    }

    protected function bootstrap(): void
    {
        if ($this->hasBootstrapped) {
            return;
        }

        /** @var Manager $manager */
        $manager = resolve(Manager::class);

        $this->blueprint = $manager->resolve($this->route);
        $this->blueprintData = (new TableRenderer($this->blueprint))->render();
        $this->searchable = $this->blueprint->searchable();
        $this->data = $this->getBlueprintData();

        $this->hasBootstrapped = true;
    }
}
