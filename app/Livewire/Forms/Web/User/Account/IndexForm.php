<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Web\User\Account;

use App\Models\User\User;
use App\Livewire\Forms\Form;

final class IndexForm extends Form
{
    public ?string $name;

    public function rules(): array
    {
        /** @var User */
        $user = $this->container->make(User::class);

        return [
            'name' => [
                'bail',
                'required',
                'string',
                'max:255',
                $this->rule->unique($user->getTable(), 'name')->ignore($this->guard->id())
            ]
        ];
    }
}
