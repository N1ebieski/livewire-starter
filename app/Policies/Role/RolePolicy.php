<?php

namespace App\Policies\Role;

use App\Models\Role\Role;
use App\Models\User\User;
use App\ValueObjects\Role\DefaultName;
use Illuminate\Database\Eloquent\Collection;

final class RolePolicy
{
    public function create(User $user): bool
    {
        return $user->hasRole(DefaultName::SUPER_ADMIN->value);
    }

    public function edit(User $user, Role $role): bool
    {
        return $user->hasRole(DefaultName::SUPER_ADMIN->value)
            && !$role->name->isAdmin();
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->hasRole(DefaultName::SUPER_ADMIN->value)
            && !$role->name->isDefault();
    }

    public function deleteMulti(User $user, Collection $roles): bool
    {
        foreach ($roles as $role) {
            if (!$this->delete($user, $role)) {
                return false;
            }
        }

        return true;
    }
}
