<?php

declare(strict_types=1);

namespace App\Queries\Permission\GetAvailable;

use App\Models\Role\Role;
use App\Models\Permission\Permission;

final class GetAvailableQuery
{
    public function __construct(
        public readonly Permission $permission,
        public readonly Role $role = new Role(),
    ) {
    }
}
