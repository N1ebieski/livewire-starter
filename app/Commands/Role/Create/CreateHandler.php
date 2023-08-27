<?php

declare(strict_types=1);

namespace App\Commands\Role\Create;

use App\Commands\Handler;
use App\Models\Permission\Permission;
use App\Commands\Role\Create\CreateCommand;
use Spatie\Permission\Models\Role as ModelsRole;

class CreateHandler extends Handler
{
    public function handle(CreateCommand $command): ModelsRole
    {
        $this->db->beginTransaction();

        try {
            $role = $command->role->newInstance($command->toArray());

            $role->save();

            $role->givePermissionTo(
                $command->permissions->map(function (Permission $permission) {
                    return $permission->name;
                })->toArray()
            );
        } catch (\Exception $e) {
            $this->db->rollBack();

            throw $e;
        }

        $this->db->commit();

        return $role->fresh();
    }
}
