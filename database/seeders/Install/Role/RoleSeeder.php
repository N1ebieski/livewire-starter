<?php

declare(strict_types=1);

namespace Database\Seeders\Install\Role;

use App\ValueObjects\Role\DefaultName;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function __construct(
        private Role $role,
        private PermissionRegistrar $permissionRegistrar
    ) {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->permissionRegistrar->forgetCachedPermissions();

        $this->role->newQuery()->firstOrCreate(['name' => DefaultName::SUPER_ADMIN->value]);

        $admin = $this->role->newQuery()->firstOrCreate(['name' => DefaultName::ADMIN->value]);

        if ($admin->wasRecentlyCreated) {
            $admin->givePermissionTo(['admin.*', 'web.*', 'api.*']);
        }

        $user = $this->role->newQuery()->firstOrCreate(['name' => DefaultName::USER->value]);

        if ($user->wasRecentlyCreated) {
            $user->givePermissionTo(['web.*']);
        }

        $api = $this->role->newQuery()->firstOrCreate(['name' => DefaultName::API->value]);

        if ($api->wasRecentlyCreated) {
            $api->givePermissionTo(['api.*']);
        }
    }
}
