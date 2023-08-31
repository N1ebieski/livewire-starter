<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\Role;

use App\Models\Role\Role;
use App\Commands\CommandBus;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;
use App\Livewire\Components\Component;
use App\Livewire\Components\HasComponent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Translation\Translator;
use App\Commands\Role\DeleteMulti\DeleteMultiCommand;
use App\Livewire\Components\Admin\DataTable\Role\DataTableComponent;

class DeleteMultiComponent extends Component
{
    use HasComponent;

    #[Locked]
    public array $ids;

    private Role $role;

    public function mount(array $ids): void
    {
        $this->ids = $ids;
    }

    public function boot(Role $role): void
    {
        $this->role = $role;
    }

    #[Computed(persist: true)]
    public function roles(): Collection
    {
        return $this->role->findMany($this->ids);
    }

    public function submit(
        CommandBus $commandBus,
        Translator $trans
    ): void {
        $this->gate->authorize('deleteMulti', [Role::class, $this->roles]);

        /** @var int */
        $deleted = $commandBus->execute(new DeleteMultiCommand($this->roles));

        $this->dispatch('refresh')->to(DataTableComponent::class);

        $this->dispatch('hide-modal', alias: 'admin.role.delete-multi-component');

        $this->dispatch('reset-selects');

        $this->dispatch(
            'create-toast',
            body: $trans->choice('role.actions.delete.multi', $deleted, ['number' => $deleted])
        );
    }

    public function render(): View
    {
        $this->gate->authorize('deleteMulti', [Role::class, $this->roles]);

        return $this->viewFactory->make('livewire.admin.role.delete-multi-component');
    }
}
