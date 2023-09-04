<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\User;

use App\Models\User\User;
use App\Commands\CommandBus;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;
use App\Livewire\Components\Component;
use App\Livewire\Components\HasComponent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Translation\Translator;
use App\Commands\User\DeleteMulti\DeleteMultiCommand;
use App\Livewire\Components\Admin\DataTables\User\DataTableComponent;

class DeleteMultiComponent extends Component
{
    use HasComponent;

    #[Locked]
    public array $ids;

    private User $user;

    public function mount(array $ids): void
    {
        $this->ids = $ids;
    }

    public function boot(User $user): void
    {
        $this->user = $user;
    }

    #[Computed(persist: true)]
    public function users(): Collection
    {
        return $this->user->findMany($this->ids);
    }

    public function submit(
        CommandBus $commandBus,
        Translator $trans
    ): void {
        $this->gate->authorize('deleteMulti', [User::class, $this->users]);

        /** @var int */
        $deleted = $commandBus->execute(new DeleteMultiCommand($this->users));

        $this->dispatch('refresh')->to(DataTableComponent::class);

        $this->dispatch('hide-modal', alias: 'admin.user.delete-multi-component');

        $this->dispatch('reset-selects');

        $this->dispatch(
            'create-toast',
            body: $trans->choice('user.actions.delete.multi', $deleted, ['number' => $deleted])
        );
    }

    public function render(): View
    {
        $this->gate->authorize('deleteMulti', [User::class, $this->users]);

        return $this->viewFactory->make('livewire.admin.user.delete-multi-component');
    }
}
