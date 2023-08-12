<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Admin\User;

use App\Models\User\User;
use App\Livewire\Forms\Form;
use App\ValueObjects\Role\Name;
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
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                $this->rule->unique($this->component->user->getTable(), 'name')->ignore($this->component->user->id)
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                $this->rule->unique($this->component->user->getTable(), 'email')->ignore($this->component->user->id)
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed'
            ],
            'roles' => [
                'required',
                'array',
                $this->rule->in(array_map(fn ($enum) => $enum->value, Name::cases()))
            ]
        ];
    }
}
