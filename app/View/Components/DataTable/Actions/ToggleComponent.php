<?php

declare(strict_types=1);

namespace App\View\Components\DataTable\Actions;

use App\View\Components\Component;
use Illuminate\Contracts\View\View;

final class ToggleComponent extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.data-table.actions.toggle-component');
    }
}
