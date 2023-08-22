<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\Role;

use Livewire\WithPagination;
use Illuminate\Contracts\View\View;
use App\Livewire\Components\HasComponent;
use App\Livewire\Components\HasTitleWithPage;
use App\Livewire\Components\FullPageComponent;
use App\View\Metas\Admin\Role\IndexMetaFactory;

final class IndexComponent extends FullPageComponent
{
    use HasTitleWithPage;
    use HasComponent;
    use WithPagination;

    private IndexMetaFactory $metaFactory;

    public function boot(IndexMetaFactory $metaFactory): void
    {
        $this->metaFactory = $metaFactory;
    }

    public function render(): View
    {
        //$this->gate->authorize('admin.role.view');

        $meta = $this->metaFactory->make($this->getPage());

        return $this->viewFactory->make('livewire.admin.role.index-component')
            ->layout('components.admin.layouts.app.app-component', compact('meta'));
    }
}
