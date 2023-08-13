<?php

declare(strict_types=1);

namespace App\Commands\User\Create;

use App\Commands\Command;
use App\Models\User\User;
use App\ValueObjects\Role\Name;
use Illuminate\Database\Eloquent\Collection;

final class CreateCommand extends Command
{
    public function __construct(
        public readonly User $user,
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly Collection $roles = new Collection()
    ) {
    }
}
