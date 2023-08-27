<?php

declare(strict_types=1);

namespace App\Models\Permission;

use App\Scopes\Role\HasRoleScopes;
use Spatie\Permission\Models\Permission as BasePermission;

final class Permission extends BasePermission
{
}
