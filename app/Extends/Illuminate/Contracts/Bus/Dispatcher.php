<?php

declare(strict_types=1);

namespace App\Extends\Illuminate\Contracts\Bus;

use Illuminate\Contracts\Bus\Dispatcher as BaseDispatcher;

/**
 * @method \Illuminate\Foundation\Bus\PendingChain chain(\Illuminate\Support\Collection|array $jobs)
 * @method \Illuminate\Bus\PendingBatch batch(\Illuminate\Support\Collection|array|mixed $jobs)
 */
interface Dispatcher extends BaseDispatcher
{
}
