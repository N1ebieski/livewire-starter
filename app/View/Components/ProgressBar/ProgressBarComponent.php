<?php

declare(strict_types=1);

namespace App\View\Components\ProgressBar;

use App\View\Components\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * @property-read array<Segment> $segments
 */
final class ProgressBarComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly array $segments,
        public readonly int $min = 0,
        public readonly int $max = 100,
        public readonly bool $active = false,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.progress-bar.progress-bar-component');
    }
}
