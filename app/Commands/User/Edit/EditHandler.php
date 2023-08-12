<?php

declare(strict_types=1);

namespace App\Commands\User\Edit;

use App\Commands\Handler;
use App\Models\User\User;
use App\Commands\CommandBus;
use App\ValueObjects\Role\Name;
use App\Commands\User\Edit\EditCommand;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\DatabaseManager as DB;

class EditHandler extends Handler
{
    public function __construct(
        protected DB $db,
        protected CommandBus $commandBus,
        private Hasher $hasher
    ) {
    }

    public function handle(EditCommand $command): User
    {
        $this->db->beginTransaction();

        try {
            $user = $command->user->fill($command->toArray());

            if (!$this->hasher->check($command->password, $user->password)) {
                $user->password = $this->hasher->make($command->password);
            }

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
