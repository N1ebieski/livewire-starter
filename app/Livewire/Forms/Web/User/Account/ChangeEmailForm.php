<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Web\User\Account;

use App\Models\User\User;
use App\Livewire\Forms\Form;
use App\Rules\PasswordConfirmation\PasswordConfirmation;

final class ChangeEmailForm extends Form
{
    public ?string $email;

    public ?string $password;

    public function rules(): array
    {
        /** @var User */
        $user = $this->guard->user();

        return [
            'email' => [
                'bail',
                'required',
                'string',
                'email',
                'max:255',
                $this->rule->unique($user->getTable(), 'email')
            ],
            'password' => [
                'bail',
                'required',
                'string',
                $this->container->make(PasswordConfirmation::class, [
                    'password' => $user->password
                ])
            ],
        ];
    }
}
