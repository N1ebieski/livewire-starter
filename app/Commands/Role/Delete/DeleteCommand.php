<?php

declare(strict_types=1);

namespace App\Commands\Role\Delete;

use App\Models\Role\Role;

class DeleteCommand
{
    public function __construct(public readonly Role $role)
    {
    }
}
