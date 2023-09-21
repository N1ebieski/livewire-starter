<?php

declare(strict_types=1);

namespace App\Livewire\Components\Web\User\Account;

use Illuminate\Contracts\View\View;
use App\Livewire\Components\Component;
use App\Livewire\Components\HasComponent;
use App\Livewire\Components\FullPageInterface;
use App\View\Metas\Web\User\Account\IndexMetaFactory;

final class IndexComponent extends Component implements FullPageInterface
{
    use HasComponent;

    public function render(IndexMetaFactory $metaFactory): View
    {
        $this->gate->allowIf(fn () => $this->guard->check());

        $meta = $metaFactory->make();

        return $this->viewFactory->make('livewire.web.user.account.index-component')
            ->layout('components.web.layouts.app.app-component', compact('meta'));
    }
}
