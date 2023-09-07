<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\Home;

use Illuminate\Contracts\View\View;
use App\Livewire\Components\HasComponent;
use App\View\Metas\Admin\Home\IndexMetaFactory;
use App\Livewire\Components\FullPage\FullPageComponent;

final class IndexComponent extends FullPageComponent
{
    use HasComponent;

    public function render(IndexMetaFactory $metaFactory): View
    {
        $this->gate->authorize('admin.home.view');

        $meta = $metaFactory->make();

        return $this->viewFactory->make('livewire.admin.home.index-component')
            ->layout('components.admin.layouts.app.app-component', compact('meta'));
    }
}
