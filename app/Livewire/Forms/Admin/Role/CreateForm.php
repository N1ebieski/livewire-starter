<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Admin\Role;

use App\Models\Role\Role;
use App\Livewire\Forms\Form;
use App\Models\Permission\Permission;
use App\Livewire\Components\Admin\Role\CreateComponent;

/**
 * @property-read CreateComponent $component
 */
final class CreateForm extends Form
{
    public ?string $name = null;

    public array $permissions = [];

    public function rules(): array
    {
        /** @var Role */
        $role = $this->container->make(Role::class);

        $permission = $this->container->make(Permission::class);

        return [
            'name' => [
                'bail',
                'required',
                'string',
                'max:255',
                $this->rule->unique($role->getTable(), 'name')
            ],
            'permissions' => [
                'bail',
                'required',
                'array',
                $this->rule->exists($permission->getTable(), 'id')
            ]
        ];
    }
}
