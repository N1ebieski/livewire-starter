<?php

declare(strict_types=1);

namespace App\Commands\Role\DeleteMulti;

use App\Models\Role\Role;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property-read Collection<Role> $roles
 */
final class DeleteMultiCommand
{
    public function __construct(
        public readonly Collection $roles
    ) {
    }
}
