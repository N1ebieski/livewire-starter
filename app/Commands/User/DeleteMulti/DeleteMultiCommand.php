<?php

declare(strict_types=1);

namespace App\Commands\User\DeleteMulti;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property-read Collection<User> $users
 */
final class DeleteMultiCommand
{
    public function __construct(
        public readonly Collection $users
    ) {
    }
}
