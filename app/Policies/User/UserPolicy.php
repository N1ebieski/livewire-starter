<?php

declare(strict_types=1);

namespace App\Policies\User;

use App\Models\User\User;
use App\ValueObjects\Role\DefaultName;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Container\BindingResolutionException;

final class UserPolicy
{
    public function create(User $authUser): bool
    {
        return $authUser->hasRole(DefaultName::SUPER_ADMIN->value);
    }

    public function edit(User $authUser, User $user): bool
    {
        return $authUser->hasRole(DefaultName::SUPER_ADMIN->value) && ($authUser->id !== $user->id);
    }

    public function delete(User $authUser, User $user): bool
    {
        return $authUser->hasRole(DefaultName::SUPER_ADMIN->value) && ($authUser->id !== $user->id);
    }

    /**
     *
     * @param User $authUser
     * @param Collection<User> $users
     * @return bool
     * @throws BindingResolutionException
     */
    public function deleteMulti(User $authUser, Collection $users): bool
    {
        foreach ($users as $user) {
            if (!$this->delete($authUser, $user)) {
                return false;
            }
        }

        return true;
    }

    public function toggleStatusEmail(User $authUser, User $user): bool
    {
        return $authUser->hasRole(DefaultName::SUPER_ADMIN->value) && ($authUser->id !== $user->id);
    }
}
