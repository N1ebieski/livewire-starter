<?php

declare(strict_types=1);

namespace App\View\Components\Form\Tinymce;

final class Mobile
{
    public function __construct(
        public readonly bool $menubar = true,
        public readonly string $toolbar_mode = "floating",
    ) {
    }
}