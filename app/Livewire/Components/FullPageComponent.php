<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Livewire\Attributes\On;
use App\Livewire\Components\Component;

abstract class FullPageComponent extends Component
{
    protected ?int $page = null;

    #[On('updated-page')]
    public function setPage(?int $page): self
    {
        $this->page = $page;

        return $this;
    }
}
