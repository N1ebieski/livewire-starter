<?php

declare(strict_types=1);

namespace App\Commands;

use Illuminate\Support\Str;
use Illuminate\Container\Container;

final class CommandBus
{
    public function __construct(
        private Container $container,
        private Str $str
    ) {
    }

    public function execute(mixed $command): mixed
    {
        $handler = $this->resolveHandler($command);

        //@phpstan-ignore-next-line
        return $handler->handle($command);
    }

    private function resolveHandler(mixed $command): Handler
    {
        return $this->container->make($this->getHandlerName($command));
    }

    private function getHandlerName(mixed $command): string
    {
        /** @var string */
        $class = get_class($command);

        $handlerNamespace = $this->str->beforeLast($class, '\\');

        /** @var string */
        $handlerName = $this->str->replace('Command', 'Handler', class_basename($command));

        $handlerName = $handlerNamespace . '\\' . $handlerName;

        return $handlerName;
    }
}
