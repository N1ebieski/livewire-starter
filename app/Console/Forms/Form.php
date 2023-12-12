<?php

declare(strict_types=1);

namespace App\Console\Forms;

use Illuminate\Validation\Rule;
use App\Console\Commands\Handler;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Config\Repository as Config;

abstract class Form
{
    protected Handler $command;

    public function __construct(
        protected Rule $rule,
        protected Container $container,
        protected Config $config,
    ) {
    }

    public function setCommand(Handler $command): self
    {
        $this->command = $command;

        return $this;
    }

    abstract public function rules(): array;
}
