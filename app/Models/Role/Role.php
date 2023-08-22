<?php

declare(strict_types=1);

namespace App\Models\Role;

use App\Scopes\Role\HasRoleScopes;
use Spatie\Permission\Models\Role as BaseRole;

final class Role extends BaseRole
{
    use HasRoleScopes;

    /**
     * The columns of the full text index
     */
    public array $searchable = ['name'];

    public array $searchableAttributes = ['id'];

    public array $sortable = ['id', 'name', 'created_at', 'updated_at'];    
}
