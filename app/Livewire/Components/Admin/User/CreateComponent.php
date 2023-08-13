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
use App\Commands\User\Create\CreateCommand;
use Illuminate\Database\Eloquent\Collection;
use App\Livewire\Forms\Admin\User\CreateForm;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Translation\Translator;

final class CreateComponent extends Component
{
    private User $user;

    private Role $role;

    public CreateForm $form;

    public function mount(Role $role): void
    {
        $this->role = $role;

        $this->form->roles = $this->roles->where('name', Name::USER->value)->pluck('id')->toArray();
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

    private function getRolesAsCollection(): Collection
    {
        return $this->role->findMany($this->form->roles);
    }

    public function submit(
        CommandBus $commandBus,
        Translator $translator,
        UrlGenerator $urlGenerator
    ): void {
        // $this->gate->authorize('admin.user.create');

        $this->validate();

        /** @var User */
        $user = $commandBus->execute(
            new CreateCommand(
                user: $this->user,
                name: $this->form->name,
                email: $this->form->email,
                password: $this->form->password,
                roles: $this->getRolesAsCollection()
            )
        );

        $this->dispatch('hide-modal', alias: 'admin.user.create-component');

        $this->dispatch(
            'create-toast',
            body: $translator->get('user.action.create', ['name' => $user->name])
        );

        $this->redirect($urlGenerator->route('admin.user.index', [
            'search' => "attr:id:\"{$user->id}\"",
        ]), navigate: true);
    }

    public function render(): View
    {
        //$this->gate->authorize('admin.user.create');

        return $this->viewFactory->make('livewire.admin.user.create-component');
    }
}