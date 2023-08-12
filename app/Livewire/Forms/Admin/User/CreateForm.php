<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Admin\User;

use App\Models\User\User;
use App\Livewire\Forms\Form;
use App\ValueObjects\Role\Name;
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

    public array $roles = [Name::USER->value];

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                $this->rule->unique($this->component->user->getTable(), 'name')
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                $this->rule->unique($this->component->user->getTable(), 'email')
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
                $this->rule->in(array_map(fn ($enum) => $enum->value, Name::cases()))
            ]
        ];
    }
}
