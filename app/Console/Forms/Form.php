<?php

declare(strict_types=1);

namespace App\Console\Forms;

use Illuminate\Validation\Rule;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Config\Repository as Config;

abstract class Form
{
    public function __construct(
        protected Rule $rule,
        protected Container $container,
        protected Config $config,
    ) {
    }
}
