<?php

namespace JPeters\Architect\Plans;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use JPeters\Architect\Blueprints\Manager;
use Livewire\Component;

abstract class BaseTableComponent extends Component
{
    public int $index;
    public string $route = '';
    public ?Model $model = null;

    private bool $hasBootstrapped = false;
    private ?Plan $plan = null;

    public function bootstrap(): void
    {
        if ($this->hasBootstrapped) {
            return;
        }

        /** @var Manager $manager */
        $manager = resolve(Manager::class);

        $blueprint = $manager->resolve($this->route);
        $this->plan = $blueprint->plans()[$this->index];

        $this->hasBootstrapped = true;
    }

    public function mount(): void
    {
        $this->bootstrap();
    }

    public function metaData(): array
    {
        return [];
    }

    abstract protected function view(): string;

    public function render(): View
    {
        return view($this->view(), [
            'value' => $this->plan->currentValueForTable($this->model),
            'metaData' => $this->metaData(),
        ]);
    }
}
