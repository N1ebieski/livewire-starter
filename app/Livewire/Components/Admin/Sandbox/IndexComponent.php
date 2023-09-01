<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\Sandbox;

use Illuminate\Contracts\View\View;
use App\Livewire\Components\HasComponent;
use App\Livewire\Components\FullPage\FullPageComponent;
use App\View\Metas\Admin\Home\IndexMetaFactory;

class IndexComponent extends FullPageComponent
{
    use HasComponent;

    public function render(IndexMetaFactory $metaFactory): View
    {
        $this->gate->authorize('admin.home.view');

        $meta = $metaFactory->make();

        return $this->viewFactory->make('livewire.admin.sandbox.index-component')
            ->layout('components.admin.layouts.app.app-component', compact('meta'));
    }
}
