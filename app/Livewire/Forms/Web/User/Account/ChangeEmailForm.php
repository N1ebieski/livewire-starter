<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Web\User\Account;

use App\Models\User\User;
use App\Livewire\Forms\Form;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Translation\Translator;

final class ChangeEmailForm extends Form
{
    public ?string $email;

    public ?string $password;

    public function rules(): array
    {
        /** @var User */
        $user = $this->container->make(User::class);

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
                function ($attribute, $value, $fail) {
                    /** @var User */
                    $user = $this->guard->user();

                    $hasher = $this->container->make(Hasher::class);

                    $translator = $this->container->make(Translator::class);

                    if (!$hasher->check($value, $user->password)) {
                        return $fail($translator->get('passwords.confirmation'));
                    }
                }
            ],
        ];
    }
}
