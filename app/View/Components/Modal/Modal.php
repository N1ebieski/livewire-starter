<?php

declare(strict_types=1);

namespace App\View\Components\Modal;

final class Modal
{
    public function __construct(
        public readonly bool $static = false,
        public readonly bool $scrollable = false,
        public readonly ?Size $size = null
    ) {
    }
}
