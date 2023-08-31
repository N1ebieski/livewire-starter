<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\Role;

use App\Models\Role\Role;
use App\Commands\CommandBus;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;
use App\Models\Permission\Permission;
use App\Livewire\Components\Component;
use App\Livewire\Components\HasComponent;
use App\Commands\Role\Create\CreateCommand;
use Illuminate\Database\Eloquent\Collection;
use App\Livewire\Forms\Admin\Role\CreateForm;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\Collection as SupportCollection;

/**
 * @property-read Collection<Permission> $permissions
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
        Translator $translator,
        UrlGenerator $urlGenerator
    ): void {
        $this->gate->authorize('create', Role::class);

        $this->validate();

        /** @var Role */
        $role = $commandBus->execute(
            new CreateCommand(
                role: $this->role,
                name: $this->form->name,
                permissions: $this->getFormPermissionsAsCollection()
            )
        );

        $this->dispatch('hide-modal', alias: 'admin.role.create-component');

        $this->dispatch(
            'create-toast',
            body: $translator->get('role.actions.create', ['name' => $role->name->value])
        );

        $this->redirect($urlGenerator->route('admin.role.index', [
            'search' => "attr:id:\"{$role->id}\"",
        ]), navigate: true);
    }

    public function render(): View
    {
        $this->gate->authorize('create', Role::class);

        return $this->viewFactory->make('livewire.admin.role.create-component');
    }
}