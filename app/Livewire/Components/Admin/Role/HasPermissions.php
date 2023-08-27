<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\Role;

use Livewire\Attributes\Computed;
use App\Models\Permission\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

trait HasPermissions
{
    protected Permission $permission;

    public function bootHasPermissions(Permission $permission): void
    {
        $this->permission = $permission;
    }

    #[Computed(persist: true)]
    public function permissions(): Collection
    {
        return $this->permission->all();
    }

    #[Computed(persist: true)]
    public function groupedPermissions(): SupportCollection
    {
        return $this->permissions->sortBy('name')
            ->map(function (Permission $permission) {
                preg_match('/[^.]*?\.([a-z]+){1}\..*/', $permission->name, $optgroup);

                $permission->optgroup = $optgroup[1] ?? null;

                return $permission;
            })
            ->values();
    }
}
