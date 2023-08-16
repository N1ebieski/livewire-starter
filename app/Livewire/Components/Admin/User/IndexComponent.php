<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\User;

use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Http\Requests\PageRequest;
use Illuminate\Contracts\View\View;
use App\Livewire\Components\FullPageComponent;
use App\View\Metas\Admin\User\IndexMetaFactory;

final class IndexComponent extends FullPageComponent
{
    use WithPagination;

    private IndexMetaFactory $indexMetaFactory;

    public function mount(PageRequest $request): void
    {
        /**
         * Fix for livewire navigate with lazy mode.
         * @see https://github.com/livewire/livewire/discussions/5958
         */
        $this->setPage($request->query('page', 1));
    }

    public function boot(IndexMetaFactory $indexMetaFactory): void
    {
        $this->indexMetaFactory = $indexMetaFactory;
    }

    #[On('updated-page')]
    public function updateTitle(?int $page): void
    {
        $meta = $this->indexMetaFactory->make($page);

        $this->dispatch('update-title', meta: $meta);
    }

    public function render(): View
    {
        //$this->gate->authorize('admin.user.view');

        $meta = $this->indexMetaFactory->make($this->getPage());

        return $this->viewFactory->make('livewire.admin.user.index-component')
            ->layout('components.admin.layouts.app.app-component', compact('meta'));
    }
}
