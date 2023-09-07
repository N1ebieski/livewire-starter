<?php

declare(strict_types=1);

namespace App\Policies\Role;

use App\Models\Role\Role;
use App\Models\User\User;
use App\ValueObjects\Role\DefaultName;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Container\BindingResolutionException;

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

    /**
     *
     * @param User $user
     * @param Collection<Role> $roles
     * @return bool
     * @throws BindingResolutionException
     */
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
