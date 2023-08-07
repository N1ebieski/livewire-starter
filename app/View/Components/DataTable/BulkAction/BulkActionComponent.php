<?php

declare(strict_types=1);

namespace App\View\Components\DataTable\BulkAction;

use Illuminate\Support\Str;
use App\View\Components\Action;
use App\View\Components\Component;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

class BulkActionComponent extends Component
{
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly string $label,
        public readonly Action $action = Action::PRIMARY,
        public readonly array $targets = []
    ) {
    }

    public function withAttributes(array $attributes): self
    {
        $wire = (new Collection($attributes))
            ->first(fn ($value, string $key) => Str::startsWith($key, 'wire:click'));

        $this->targets = array_merge($wire, $this->targets);

        return parent::withAttributes($attributes);
    }

    public function targetsAsString(): string
    {
        return implode(',', $this->targets);
    }

    public function render(): View
    {
        return $this->viewFactory->make('components.data-table.bulk-action.bulk-action-component');
    }
}
