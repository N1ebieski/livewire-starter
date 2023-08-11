<?php

declare(strict_types=1);

namespace App\View\Components\DataTable\Action;

use Illuminate\Support\Str;
use App\View\Components\Action;
use App\View\Components\Component;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ButtonComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly string $label,
        public readonly Action $action = Action::PRIMARY,
        public readonly bool $lazy = true,
        public array $targets = []
    ) {
    }

    public function withAttributes(array $attributes): self
    {
        $wire = (new Collection($attributes))
            ->first(fn ($value, string $key) => Str::startsWith($key, 'wire:click'));

        $this->targets = array_merge([$wire], $this->targets);

        return parent::withAttributes($attributes);
    }

    public function targetsAsString(): string
    {
        return implode(',', $this->targets);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.data-table.action.button-component');
    }
}
