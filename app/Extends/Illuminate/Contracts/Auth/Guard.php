<?php

declare(strict_types=1);

namespace App\Extends\Illuminate\Contracts\Auth;

use Illuminate\Contracts\Auth\Guard as BaseGuard;

interface Guard extends BaseGuard
{
    /**
     * Get the currently authenticated user.
     *
     * @return \App\Models\User\User|null
     */
    public function user();
}
