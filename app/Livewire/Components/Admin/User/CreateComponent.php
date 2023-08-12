<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\User;

use App\Models\User\User;
use App\Commands\CommandBus;
use App\ValueObjects\Role\Name;
use Livewire\Attributes\Locked;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Validator;
use App\Livewire\Components\Component;
use App\Commands\User\Create\CreateCommand;
use App\Livewire\Forms\Admin\User\CreateForm;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Translation\Translator;

final class CreateComponent extends Component
{
    #[Locked]
    public User $user;

    public CreateForm $form;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function boot(): void
    {
        $this->withValidator(function (Validator $validator) {
            $validator->after(function (Validator $validator) {
                if ($validator->errors()->has('form.password')) {
                    $this->form->reset('password', 'password_confirmation');
                }
            });
        });
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
                roles: array_map(fn (string $role) => Name::from($role), $this->form->roles)
            )
        );

        $this->dispatch('hide-modal', alias: 'admin.user.create-component');

        $this->dispatch(
            'create-toast',
            body: $translator->get("user.action.create", ['name' => $user->name])
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
