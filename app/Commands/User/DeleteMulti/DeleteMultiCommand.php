<?php

declare(strict_types=1);

namespace App\Commands\User\DeleteMulti;

use Illuminate\Database\Eloquent\Collection;

class DeleteMultiCommand
{
    public function __construct(
        public readonly Collection $users
    ) {
    }
}
