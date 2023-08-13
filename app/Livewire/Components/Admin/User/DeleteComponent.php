<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\User;

use App\Models\User\User;
use App\Commands\CommandBus;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;
use App\Livewire\Components\Component;
use App\Commands\User\Delete\DeleteCommand;
use Illuminate\Contracts\Translation\Translator;
use App\Livewire\Components\Admin\DataTable\User\DataTableComponent;

class DeleteComponent extends Component
{
    //phpcs:ignore
    private User $_user;

    public function mount(User $user): void
    {
        $this->_user = $user;
    }

    #[Computed(persist: true)]
    public function user(): User
    {
        return $this->_user;
    }

    public function submit(
        CommandBus $commandBus,
        Translator $trans
    ): void {
        // $this->gate->authorize('admin.user.delete');

        $commandBus->execute(new DeleteCommand($this->user));

        $this->dispatch('refresh')->to(DataTableComponent::class);

        $this->dispatch('hide-modal', alias: 'admin.user.delete-component');

        $this->dispatch(
            'create-toast',
            body: $trans->get('user.action.delete.single', ['name' => $this->user->name])
        );
    }

    public function render(): View
    {
        // $this->gate->authorize('admin.user.delete');

        return $this->viewFactory->make('livewire.admin.user.delete-component');
    }
}
