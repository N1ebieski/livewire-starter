<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\Role;

use App\Models\Role\Role;
use App\Queries\QueryBus;
use Livewire\Attributes\Computed;
use App\Models\Permission\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use App\Queries\Permission\GetAvailable\GetAvailableQuery;

/**
 * @property-read Role $role
 * @property-read Collection<Permission> $permissions;
 */
trait HasPermissions
{
    private Permission $permission;

    private QueryBus $queryBus;

    public function bootHasPermissions(
        Permission $permission,
        QueryBus $queryBus
    ): void {
        $this->permission = $permission;

        $this->queryBus = $queryBus;
    }

    #[Computed(persist: true)]
    public function permissions(): Collection
    {
        return $this->queryBus->execute(new GetAvailableQuery(
            permission: $this->permission,
            role: $this->role
        ));
    }

    #[Computed(persist: true)]
    public function groupedPermissions(): SupportCollection
    {
        return $this->permissions->sortBy('name')
            ->map(function (Permission $permission) {
                preg_match('/[^.]*?\.([a-z]+){1}\..*/', $permission->name, $optgroup);

                //@phpstan-ignore-next-line
                $permission->optgroup = $optgroup[1] ?? null;

                return $permission;
            })
            ->values();
    }
}
