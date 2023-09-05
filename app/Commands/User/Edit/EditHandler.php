<?php

declare(strict_types=1);

namespace App\Commands\User\Edit;

use App\Commands\Handler;
use App\Models\Role\Role;
use App\Models\User\User;
use App\Commands\CommandBus;
use App\ValueObjects\Role\DefaultName;
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

            $user->syncRoles([
                DefaultName::USER->value,
                ...$command->roles->map(fn (Role $role) => $role->name->value)->toArray()
            ]);
        } catch (\Exception $e) {
            $this->db->rollBack();

            throw $e;
        }

        $this->db->commit();

        /** @var User */
        return $user->fresh();
    }
}
