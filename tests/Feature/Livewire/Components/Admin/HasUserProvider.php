<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Components\Admin;

use App\Models\Role\Role;
use App\Models\User\User;
use Symfony\Component\HttpFoundation\Response;

trait HasUserProvider
{
    public static function userProvider(): array
    {
        return [
            'super-admin' => [
                function () {
                    return User::factory()->superAdmin()->create();
                },
                Response::HTTP_OK
            ],
            'admin' => [
                function () {
                    return User::factory()->admin()->create();
                },
                Response::HTTP_OK
            ],            
            'user-with-a-role-with-a-specific-permission' => [
                function (string $permission) {
                    return User::factory()->afterCreating(function (User $user) use ($permission) {
                        $role = Role::factory()->afterCreating(function (Role $role) use ($permission) {
                            $role->givePermissionTo($permission);
                        })->create();

                        $user->assignRole($role->name->value);
                    })->create();
                },
                Response::HTTP_OK
            ],
            'user' => [
                function () {
                    return User::factory()->user()->create();
                },
                Response::HTTP_FORBIDDEN
            ],
            'guest' => [
                null,
                Response::HTTP_FORBIDDEN
            ]
        ];
    }
}
