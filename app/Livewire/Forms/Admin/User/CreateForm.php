<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Admin\User;

use App\Models\Role\Role;
use App\Models\User\User;
use App\Livewire\Forms\Form;
use App\Livewire\Components\Admin\User\CreateComponent;

/**
 * @property-read CreateComponent $component
 */
final class CreateForm extends Form
{
    public ?string $name = null;

    public ?string $email = null;

    public ?string $password = null;

    public ?string $password_confirmation = null;

    public array $roles;

    public function rules(): array
    {
        /** @var Role */
        $role = $this->container->make(Role::class);

        /** @var User */
        $user = $this->container->make(User::class);

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                $this->rule->unique($user->getTable(), 'name')
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                $this->rule->unique($user->getTable(), 'email')
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed'
            ],
            'roles' => [
                'required',
                'array',
                $this->rule->exists($role->getTable(), 'id')
            ]
        ];
    }
}
