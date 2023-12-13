<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\User;

use App\Models\Role\Role;
use App\Models\User\User;
use App\Commands\CommandBus;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;
use App\Livewire\Components\Component;
use App\Commands\User\Edit\EditCommand;
use App\Livewire\Components\HasComponent;
use App\Livewire\Forms\Admin\User\EditForm;
use Illuminate\Database\Eloquent\Collection;
use App\View\Components\DataTable\Row\Action;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Translation\Translator;
use App\Livewire\Components\Admin\DataTables\User\DataTableComponent;

/**
 * @property EditForm $form
 */
final class EditComponent extends Component
{
    use HasComponent;

    #[Locked]
    public User $user;

    private Role $role;

    public EditForm $form;

    public function mount(User $user): void
    {
        $this->user = $user;

        $this->form->name = $user->name;
        $this->form->email = $user->email;
        $this->form->roles = $user->roles->pluck('id')->toArray();
    }

    public function boot(Role $role): void
    {
        $this->role = $role;

        $this->withValidator(function (Validator $validator) {
            $validator->after(function (Validator $validator) {
                if ($validator->errors()->has('form.password')) {
                    $this->form->reset('password', 'password_confirmation');
                }
            });
        });
    }

    #[Computed(persist: true)]
    public function roles(): Collection
    {
        return $this->role->all();
    }

    private function getFormRolesAsCollection(): Collection
    {
        return $this->role->findMany($this->form->roles);
    }

    public function submit(
        CommandBus $commandBus,
        Translator $translator
    ): void {
        $this->gate->authorize('edit', $this->user);

        $this->validate();

        /** @var User */
        $user = $commandBus->execute(
            new EditCommand(
                user: $this->user,
                name: $this->form->name, //@phpstan-ignore-line
                email: $this->form->email, //@phpstan-ignore-line
                password: $this->form->password ?? $this->user->password,
                roles: $this->getFormRolesAsCollection()
            )
        );

        $this->dispatch('refresh')->to(DataTableComponent::class);

        $this->dispatch('hide-modal', alias: $this->alias);

        $this->dispatch(
            'create-toast',
            body: $translator->get('user.messages.edit', ['name' => $user->name])
        );

        $this->dispatch(
            'highlight',
            ids: [$user->id],
            alias: $this->livewireHelper->getAlias(DataTableComponent::class),
            action: Action::PRIMARY->value
        );
    }

    public function render(): View
    {
        $this->gate->authorize('edit', $this->user);

        return $this->viewFactory->make('livewire.admin.user.edit-component');
    }
}
