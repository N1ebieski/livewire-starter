<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Admin\Role;

use App\Models\Role\Role;
use App\Livewire\Forms\Form;
use App\Models\Permission\Permission;
use App\ValueObjects\Role\DefaultName;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Contracts\Database\Query\Builder;
use App\Livewire\Components\Admin\Role\EditComponent;

/**
 * @property-read EditComponent $component
 */
final class EditForm extends Form
{
    public ?string $name;

    public array $permissions;

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
                $this->rule->unique($role->getTable(), 'name')->ignore($this->component->role->id),
                $this->component->role->name->isDefault() ?
                    $this->rule->in([$this->component->role->name->value]) : null
            ],
            'permissions' => [
                'bail',
                'required',
                'array',
            ],
            'permissions.*' => [
                'bail',
                'integer',
                $this->rule->exists($permission->getTable(), 'id')
                    ->when(
                        $this->component->role->name->isEqualsDefault(DefaultName::USER),
                        function (Exists $builder) {
                            return $builder->where(function (Builder $builder) {
                                return $builder->where('name', 'like', 'web.%')
                                    ->orWhere('name', 'like', 'api.%');
                            });
                        }
                    )
                    ->when(
                        $this->component->role->name->isEqualsDefault(DefaultName::API),
                        function (Exists $builder) {
                            return $builder->where(function (Builder $builder) {
                                return $builder->where('name', 'like', 'api.%');
                            });
                        }
                    )
            ]
        ];
    }
}
