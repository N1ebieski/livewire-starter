<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\User;

use App\Models\User\User;
use App\Commands\CommandBus;
use Livewire\Attributes\Locked;
use Illuminate\Contracts\View\View;
use App\Livewire\Components\Component;
use App\Livewire\Components\HasComponent;
use App\Commands\User\Delete\DeleteCommand;
use Illuminate\Contracts\Translation\Translator;
use App\Livewire\Components\Admin\DataTables\User\DataTableComponent;

class DeleteComponent extends Component
{
    use HasComponent;

    #[Locked]
    public User $user;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function submit(
        CommandBus $commandBus,
        Translator $trans
    ): void {
        $this->gate->authorize('delete', $this->user);

        $commandBus->execute(new DeleteCommand($this->user));

        $this->dispatch('refresh')->to(DataTableComponent::class);

        $this->dispatch('hide-modal', alias: 'admin.user.delete-component');

        $this->dispatch(
            'create-toast',
            body: $trans->get('user.actions.delete.single', ['name' => $this->user->name])
        );
    }

    public function render(): View
    {
        $this->gate->authorize('delete', $this->user);

        return $this->viewFactory->make('livewire.admin.user.delete-component');
    }
}
