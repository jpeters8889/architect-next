<?php

namespace JPeters\Architect\Http\Livewire\Blueprints;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use JPeters\Architect\Blueprints\Blueprint;
use JPeters\Architect\Blueprints\Manager;
use JPeters\Architect\Blueprints\TableRenderer;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public string $route = '';
    public string $title = '';
    public ?Collection $headers = null;
    public ?Collection $columns = null;
    public iterable $currentData = [];

    protected Builder $data;

    public array $settings = [
      'paginated' => false,
      'searchable' => true,
      'canAdd' => false,
    ];

    public string $searchText = '';

    private bool $hasBootstrapped = false;
    private ?TableRenderer $tableRenderer = null;
    private ?Blueprint $blueprint = null;

    public function mount(): void
    {
        $this->bootstrap();

        $this->currentData = $this->populateTableData();
    }

    public function render(): View
    {
        return view('architect::livewire.blueprints.table');
    }

    protected function populateTableData(): iterable
    {
        $builder = $this->tableRenderer->data();

        if ($this->settings['searchable']) {
            foreach ($this->columns as $column) {
                $builder->where($column, 'like', "%{$this->searchText}%");
            }
        }

        $this->data = $builder;

        if ($this->settings['paginated']) {
            return $this->data->paginate($this->blueprint->perPage())->items();
        }

        return $this->data->get();
    }

    protected function bootstrap(): void
    {
        if ($this->hasBootstrapped) {
            return;
        }

        /** @var Manager $manager */
        $manager = resolve(Manager::class);

        $this->blueprint = $manager->resolve($this->route);
        $this->tableRenderer = new TableRenderer($this->blueprint);

        $this->title = $this->blueprint->blueprintName();
        $this->headers = $this->tableRenderer->headers();
        $this->columns = $this->tableRenderer->columns();

        $this->settings['searchable'] = $this->blueprint->searchable();
        $this->settings['canAdd'] = $this->blueprint->canAdd(auth()->user());

        $this->hasBootstrapped = true;
    }

    public function runSearch()
    {
        $this->bootstrap();

        $this->currentData = $this->populateTableData();
    }

    public function canEditRow(Model $model, Authenticatable $user): bool
    {
        return $this->blueprint->canEdit($model, $user);
    }
}
