<?php

declare(strict_types=1);

namespace App\Livewire\Components\Modal;

use App\Extends\Livewire\Wireable;
use App\View\Components\Modal\Size;
use App\View\Components\Modal\Modal as BootstrapModal;

final class Modal extends Wireable
{
    public function __construct(
        public readonly string $alias,
        public readonly BootstrapModal $modal = new BootstrapModal(),
        public readonly array $params = []
    ) {
    }

    public function toLivewire(): array
    {
        return json_decode(json_encode($this) ?: '', true);
    }

    /**
     * @param array $value
     * @return Modal
     */
    public static function fromLivewire($value): self
    {
        $value['modal']['size'] = Size::tryFrom($value['modal']['size'] ?? '');
        $value['modal'] = new BootstrapModal(...$value['modal']);

        return new self(...$value);
    }
}
