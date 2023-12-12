<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\Role;

use App\Models\Role\Role;
use App\Commands\CommandBus;
use Illuminate\Contracts\View\View;
use App\Models\Permission\Permission;
use App\Livewire\Components\Component;
use App\Livewire\Components\HasComponent;
use App\Commands\Role\Create\CreateCommand;
use Illuminate\Database\Eloquent\Collection;
use App\Livewire\Forms\Admin\Role\CreateForm;
use Illuminate\Contracts\Translation\Translator;

/**
 * @property-read Collection<Permission> $permissions
 * @property-write Role $role
 * @property CreateForm $form
 */
final class CreateComponent extends Component
{
    use HasComponent;
    use HasPermissions;

    private Role $role;

    public CreateForm $form;

    public function boot(Role $role): void
    {
        $this->role = $role;
    }

    private function getFormPermissionsAsCollection(): Collection
    {
        return $this->permission->findMany($this->form->permissions);
    }

    public function submit(
        CommandBus $commandBus,
        Translator $translator
    ): void {
        $this->gate->authorize('create', Role::class);

        $this->validate();

        /** @var Role */
        $role = $commandBus->execute(
            new CreateCommand(
                role: $this->role,
                name: $this->form->name, //@phpstan-ignore-line
                permissions: $this->getFormPermissionsAsCollection()
            )
        );

        $this->dispatch('hide-modal', alias: $this->alias);

        $this->dispatch(
            'create-toast',
            body: $translator->get('role.messages.create', ['name' => $role->name->value])
        );

        $this->dispatch('created-role', role: $role->id);
    }

    public function render(): View
    {
        $this->gate->authorize('create', Role::class);

        return $this->viewFactory->make('livewire.admin.role.create-component');
    }
}
