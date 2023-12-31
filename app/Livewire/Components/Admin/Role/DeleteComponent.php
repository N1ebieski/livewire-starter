<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\Role;

use App\Models\Role\Role;
use App\Commands\CommandBus;
use Livewire\Attributes\Locked;
use Illuminate\Contracts\View\View;
use App\Livewire\Components\Component;
use App\Livewire\Components\HasComponent;
use App\Commands\Role\Delete\DeleteCommand;
use Illuminate\Contracts\Translation\Translator;
use App\Livewire\Components\Admin\DataTables\Role\DataTableComponent;

final class DeleteComponent extends Component
{
    use HasComponent;

    #[Locked]
    public Role $role;

    public function mount(Role $role): void
    {
        $this->role = $role;
    }

    public function submit(
        CommandBus $commandBus,
        Translator $translator
    ): void {
        $this->gate->authorize('delete', $this->role);

        $commandBus->execute(new DeleteCommand($this->role));

        $this->dispatch('refresh')->to(DataTableComponent::class);

        $this->dispatch('hide-modal', alias: $this->alias);

        $this->dispatch(
            'create-toast',
            body: $translator->get('role.messages.delete.single', ['name' => $this->role->name])
        );
    }

    public function render(): View
    {
        $this->gate->authorize('delete', $this->role);

        return $this->viewFactory->make('livewire.admin.role.delete-component');
    }
}
