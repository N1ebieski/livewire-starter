<?php

declare(strict_types=1);

namespace App\View\Components\Forms\Tomselect;

final class Tomselect
{
    public function __construct(
        public readonly ?string $valueField = 'value',
        public readonly ?string $labelField = 'text',
        public readonly array $searchField = ['text'],
        public readonly array $plugins = ["remove_button"],
        public readonly ?int $maxItems = 1,
        public readonly ?string $placeholder = null,
        public readonly array $options = [],
        public readonly array $items = [],
        public readonly bool $allowEmptyOption = true,
        public readonly bool $copyClassesToDropdown = true,
        public readonly string $dropdownParent = "body",
        public readonly bool $createOnBlur = true,
        public readonly bool $create = false,
        public readonly Render $render = new Render()
    ) {
    }
}
