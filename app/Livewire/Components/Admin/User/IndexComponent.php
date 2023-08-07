<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\User;

use Illuminate\Contracts\View\View;
use App\Livewire\Components\FullPageComponent;
use App\View\Metas\Admin\User\IndexMetaFactory;

class IndexComponent extends FullPageComponent
{
    public function render(IndexMetaFactory $indexMetaFactory): View
    {
        //$this->gate->authorize('admin.user.view');

        $meta = $indexMetaFactory->make($this->page);

        return $this->viewFactory->make('livewire.admin.user.index-component')
            ->layout('components.admin.layouts.app.app-component', compact('meta'));
    }
}
