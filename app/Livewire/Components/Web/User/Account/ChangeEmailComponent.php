<?php

declare(strict_types=1);

namespace App\Livewire\Components\Web\User\Account;

use App\Models\User\User;
use App\Commands\CommandBus;
use Illuminate\Contracts\View\View;
use App\Livewire\Components\Component;
use Illuminate\Support\ValidatedInput;
use App\Commands\User\Edit\EditCommand;
use App\Livewire\Components\HasComponent;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Translation\Translator;
use App\Livewire\Forms\Web\User\Account\ChangeEmailForm;

/**
 * @property ChangeEmailForm $form
 */
final class ChangeEmailComponent extends Component
{
    use HasComponent;

    public ChangeEmailForm $form;

    public function mount(): void
    {
        /** @var User */
        $user = $this->guard->user();

        $this->form->email = $user->email;

        $this->form->password = null;
    }

    public function boot(): void
    {
        $this->withValidator(function (Validator $validator) {
            $validator->after(function (Validator $validator) {
                if ($validator->errors()->isNotEmpty()) {
                    $this->form->reset('password');
                }
            });
        });
    }

    public function submit(
        CommandBus $commandBus,
        Translator $translator
    ): void {
        $this->gate->allowIf(fn () => $this->guard->check());

        /** @var ValidatedInput */
        $validated = $this->form->safe();

        /** @var User */
        $user = $this->guard->user();

        /** @var User */
        $user = $commandBus->execute(
            new EditCommand(
                user: $user,
                name: $user->name,
                email: $validated->email,
                password: $user->password,
                roles: $user->roles
            )
        );

        $user->sendEmailVerificationNotification();

        $this->dispatch('hide-modal', alias: $this->alias);

        $this->dispatch(
            'create-toast',
            body: $translator->get('account.messages.change_email', ['name' => $user->name])
        );
    }

    public function render(): View
    {
        $this->gate->allowIf(fn () => $this->guard->check());

        return $this->viewFactory->make('livewire.web.user.account.change-email-component');
    }
}
