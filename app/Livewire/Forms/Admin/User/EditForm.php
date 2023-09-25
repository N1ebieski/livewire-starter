<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Admin\User;

use App\Models\Role\Role;
use App\Models\User\User;
use App\Livewire\Forms\Form;
use App\Livewire\Components\Admin\User\EditComponent;

/**
 * @property-read EditComponent $component
 */
final class EditForm extends Form
{
    public ?string $name;

    public ?string $email;

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
                'bail',
                'required',
                'string',
                'max:255',
                $this->rule->unique($user->getTable(), 'name')->ignore($this->component->user->id)
            ],
            'email' => [
                'bail',
                'required',
                'string',
                'email',
                'max:255',
                $this->rule->unique($user->getTable(), 'email')->ignore($this->component->user->id)
            ],
            'password' => [
                'bail',
                'nullable',
                'string',
                'min:8',
                'confirmed'
            ],
            'roles' => [
                'bail',
                'required',
                'array',
                $this->rule->exists($role->getTable(), 'id')
            ]
        ];
    }
}
