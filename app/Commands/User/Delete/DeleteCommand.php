<?php

declare(strict_types=1);

namespace App\Commands\User\Delete;

use App\Models\User\User;

final class DeleteCommand
{
    public function __construct(public readonly User $user)
    {
    }
}
