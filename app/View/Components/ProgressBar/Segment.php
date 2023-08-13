<?php

declare(strict_types=1);

namespace App\View\Components\ProgressBar;

use App\View\Components\ProgressBar\Action;

class Segment
{
    public function __construct(
        public readonly string $label,
        public readonly int $value,
        public readonly Action $action
    ) {
    }
}
