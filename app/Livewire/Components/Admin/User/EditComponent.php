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
use App\Commands\User\Edit\EditCommand;
use App\Livewire\Forms\Admin\User\EditForm;
use Illuminate\Contracts\Translation\Translator;
use App\Livewire\Components\Admin\DataTable\User\RowComponent;

final class EditComponent extends Component
{
    #[Locked]
    public User $user;

    public EditForm $form;

    public function mount(User $user): void
    {
        $this->user = $user;

        $this->form->name = $user->name;
        $this->form->email = $user->email;
        $this->form->roles = $user->roles->pluck('name')->toArray();
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
        Translator $translator
    ): void {
        // $this->gate->authorize('admin.user.edit');

        $this->validate();

        /** @var User */
        $this->user = $commandBus->execute(
            new EditCommand(
                user: $this->user,
                name: $this->form->name,
                email: $this->form->email,
                password: $this->form->password ?? $this->user->password,
                roles: array_map(fn (string $role) => Name::from($role), $this->form->roles)
            )
        );

        $this->dispatch('hide-modal', alias: 'admin.user.edit-component');

        $this->dispatch(
            'create-toast',
            body: $translator->get('user.action.edit', ['name' => $this->user->name])
        );

        $this->dispatch("refresh.{$this->user->id}");

        $this->dispatch('highlight', ids: [$this->user->id], action: 'confirm');
    }

    public function render(): View
    {
        //$this->gate->authorize('admin.user.edit');

        return $this->viewFactory->make('livewire.admin.user.edit-component');
    }
}
