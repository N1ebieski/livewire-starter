<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\User;

use Livewire\WithPagination;
use Illuminate\Contracts\View\View;
use App\Livewire\Components\Component;
use App\Livewire\Components\HasComponent;
use App\Livewire\Components\HasTitleWithPage;
use App\Livewire\Components\FullPageInterface;
use App\View\Metas\Admin\User\IndexMetaFactory;

final class IndexComponent extends Component implements FullPageInterface
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
        $this->gate->authorize('admin.user.view');

        $meta = $this->metaFactory->make($this->getPage());

        return $this->viewFactory->make('livewire.admin.user.index-component')
            ->layout('components.admin.layouts.app.app-component', compact('meta'));
    }
}
