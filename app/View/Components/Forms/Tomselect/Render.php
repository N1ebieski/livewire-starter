<?php

declare(strict_types=1);

namespace App\View\Components\Forms\Tomselect;

final class Render
{
    public function __construct(
        public readonly ?string $option = null,
    ) {
    }
}
