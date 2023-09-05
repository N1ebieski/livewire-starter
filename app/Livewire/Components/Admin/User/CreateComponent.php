<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\User;

use App\Models\Role\Role;
use App\Models\User\User;
use App\Commands\CommandBus;
use App\ValueObjects\Role\Name;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Validator;
use App\Livewire\Components\Component;
use App\ValueObjects\Role\DefaultName;
use App\Livewire\Components\HasComponent;
use App\Commands\User\Create\CreateCommand;
use Illuminate\Database\Eloquent\Collection;
use App\Livewire\Forms\Admin\User\CreateForm;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\Collection as SupportCollection;

/**
 * @property-read Collection<Role> $roles
 * @property CreateForm $form
 */
final class CreateComponent extends Component
{
    use HasComponent;

    private User $user;

    private Role $role;

    public CreateForm $form;

    public function mount(?string $role = null): void
    {
        $this->form->roles = $this->roles->where('name', new Name(DefaultName::USER->value))
            ->pluck('id')
            ->when($role, fn (SupportCollection $collection) => $collection->merge([$role]))
            ->toArray();
    }

    public function boot(
        User $user,
        Role $role
    ): void {
        $this->user = $user;
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
        $this->gate->authorize('create', User::class);

        $this->validate();

        /** @var User */
        $user = $commandBus->execute(
            new CreateCommand(
                user: $this->user,
                name: $this->form->name, //@phpstan-ignore-line
                email: $this->form->email, //@phpstan-ignore-line
                password: $this->form->password, //@phpstan-ignore-line
                roles: $this->getFormRolesAsCollection()
            )
        );

        $this->dispatch('hide-modal', alias: 'admin.user.create-component');

        $this->dispatch(
            'create-toast',
            body: $translator->get('user.actions.create', ['name' => $user->name])
        );

        $this->dispatch('created-user', user: $user->id);
    }

    public function render(): View
    {
        $this->gate->authorize('create', User::class);

        return $this->viewFactory->make('livewire.admin.user.create-component');
    }
}
