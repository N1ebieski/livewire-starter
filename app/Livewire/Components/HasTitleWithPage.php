<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Livewire\Attributes\On;
use App\Http\Requests\PageRequest;

trait HasTitleWithPage
{
    public function mountHasTitleWithPage(PageRequest $request): void
    {
        /**
         * Fix for livewire navigate with lazy mode.
         * @see https://github.com/livewire/livewire/discussions/5958
         */
        $this->setPage($request->query('page', "1"));
    }

    #[On('updated-page')]
    public function updateTitle(?int $page): void
    {
        $meta = $this->metaFactory->make($page);

        $this->dispatch('update-meta', meta: $meta);
    }
}
