<?php

namespace App\Policies\Role;

use App\Models\Role\Role;
use App\Models\User\User;
use App\ValueObjects\Role\Name;
use Illuminate\Database\Eloquent\Collection;

final class RolePolicy
{
    public function create(User $user): bool
    {
        return $user->hasRole(Name::SUPER_ADMIN->value);
    }

    public function edit(User $user, Role $role): bool
    {
        return $user->hasRole(Name::SUPER_ADMIN->value)
            && !in_array($role->name, [Name::SUPER_ADMIN, Name::ADMIN]);
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->hasRole(Name::SUPER_ADMIN->value)
            && !in_array($role->name, Name::cases());
    }

    public function deleteMulti(User $user, Collection $roles): bool
    {
        foreach ($roles as $user) {
            if (!$this->delete($user, $user)) {
                return false;
            }
        }

        return true;
    }
}
