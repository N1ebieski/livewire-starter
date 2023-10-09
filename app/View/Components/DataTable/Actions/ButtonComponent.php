<?php

declare(strict_types=1);

namespace App\View\Components\DataTable\Actions;

use App\View\Components\Component;
use Illuminate\Contracts\View\View;
use App\View\Components\Button\Type;
use App\View\Components\Button\Action;
use Illuminate\Contracts\View\Factory as ViewFactory;

final class ButtonComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly ?string $label = null,
        public readonly ?Action $action = Action::PRIMARY,
        public readonly Type $type = Type::BUTTON,
        public readonly bool $responsive = true
    ) {
    }

    public function withAttributes(array $attributes): self
    {
        return parent::withAttributes(array_merge(match ($this->type) {
            Type::SUBMIT => [
                'type' => 'submit',
            ],
            Type::A => [
                'role' => 'button'
            ],
            default => [
                'type' => 'button'
            ]
        }, $attributes));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.data-table.actions.button-component');
    }
}
