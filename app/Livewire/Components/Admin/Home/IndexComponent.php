<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\Home;

use Illuminate\Contracts\View\View;
use App\Livewire\Components\FullPageComponent;
use App\View\Metas\Admin\Home\IndexMetaFactory;

class IndexComponent extends FullPageComponent
{
    public function render(IndexMetaFactory $indexMetaFactory): View
    {
        //$this->gate->authorize('admin.home.view');

        $meta = $indexMetaFactory->make();

        return $this->viewFactory->make('livewire.admin.home.index-component')
            ->layout('components.admin.layouts.app.app-component', compact('meta'));
    }
}
