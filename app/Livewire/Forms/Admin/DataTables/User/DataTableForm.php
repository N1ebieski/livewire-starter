<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Admin\DataTables\User;

use App\Models\Role\Role;
use Livewire\Attributes\Url;
use App\ValueObjects\User\StatusEmail;
use App\Livewire\Forms\DataTable\DataTableForm as BaseDataTableForm;

final class DataTableForm extends BaseDataTableForm
{
    #[Url(as: 'columns')]
    public array $columns = ['id', 'name', 'email', 'roles', 'created_at', 'updated_at'];

    #[Url(as: 'status_email')]
    public ?string $status_email = null;

    #[Url(as: 'role')]
    public ?string $role = null;

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function rules(): array
    {
        /** @var Role */
        $role = $this->container->make(Role::class);

        return [
            'status_email' => [
                'bail',
                'string',
                'nullable',
                $this->rule->in(array_map(fn ($enum) => $enum->value, StatusEmail::cases()))
            ],
            'role' => [
                'bail',
                'integer',
                'nullable',
                $this->rule->exists($role->getTable(), 'id')
            ],
            ...parent::rules()
        ];
    }
}
