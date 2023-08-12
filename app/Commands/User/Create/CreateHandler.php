<?php

declare(strict_types=1);

namespace App\Commands\User\Create;

use App\Commands\Handler;
use App\Models\User\User;
use App\Commands\CommandBus;
use App\ValueObjects\Role\Name;
use Illuminate\Contracts\Hashing\Hasher;
use App\Commands\User\Create\CreateCommand;
use Illuminate\Database\DatabaseManager as DB;

class CreateHandler extends Handler
{
    public function __construct(
        protected DB $db,
        protected CommandBus $commandBus,
        private Hasher $hasher
    ) {
    }

    public function handle(CreateCommand $command): User
    {
        $this->db->beginTransaction();

        try {
            $user = $command->user->newInstance($command->toArray());

            $user->password = $this->hasher->make($command->password);

            $user->save();

            $user->assignRole([
                Name::USER->value,
                ...array_map(fn (Name $role) => $role->value, $command->roles)
            ]);
        } catch (\Exception $e) {
            $this->db->rollBack();

            throw $e;
        }

        $this->db->commit();

        return $user->fresh();
    }
}
