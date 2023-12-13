<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\Role;

use App\Models\Role\Role;
use App\Commands\CommandBus;
use Livewire\Attributes\Locked;
use Illuminate\Contracts\View\View;
use App\Livewire\Components\Component;
use App\Commands\Role\Edit\EditCommand;
use App\Livewire\Components\HasComponent;
use App\Livewire\Forms\Admin\Role\EditForm;
use Illuminate\Database\Eloquent\Collection;
use App\View\Components\DataTable\Row\Action;
use Illuminate\Contracts\Translation\Translator;
use App\Livewire\Components\Admin\DataTables\Role\DataTableComponent;

/**
 * @property-write Role $role
 * @property EditForm $form
 */
final class EditComponent extends Component
{
    use HasComponent;
    use HasPermissions;

    #[Locked]
    public Role $role;

    public EditForm $form;

    public function mount(Role $role): void
    {
        $this->role = $role;

        $this->form->name = $role->name->value;
        $this->form->permissions = $role->permissions->pluck('id')->toArray();

        if ($this->role->name->isDefault()) {
            $this->setPropertyAttribute('form.name', new Locked());
        }
    }

    private function getPermissionsAsCollection(array $permissions): Collection
    {
        return $this->permission->findMany($permissions);
    }

    public function submit(
        CommandBus $commandBus,
        Translator $translator
    ): void {
        $this->gate->authorize('edit', $this->role);

        /** @var ValidatedInput&EditForm */
        $validated = $this->form->safe();

        /** @var Role */
        $role = $commandBus->execute(new EditCommand(
            role: $this->role,
            name: $validated->name, //@phpstan-ignore-line
            permissions: $this->getPermissionsAsCollection($validated->permissions)
        ));

        $this->dispatch('refresh')->to(DataTableComponent::class);

        $this->dispatch('hide-modal', alias: $this->alias);

        $this->dispatch(
            'create-toast',
            body: $translator->get('role.messages.edit', ['name' => $role->name->value])
        );

        $this->dispatch(
            'highlight',
            ids: [$role->id],
            alias: $this->livewireHelper->getAlias(DataTableComponent::class),
            action: Action::PRIMARY->value
        );
    }

    public function render(): View
    {
        $this->gate->authorize('edit', $this->role);

        return $this->viewFactory->make('livewire.admin.role.edit-component');
    }
}
