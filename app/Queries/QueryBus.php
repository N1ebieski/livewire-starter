<?php

declare(strict_types=1);

namespace App\Queries;

use Illuminate\Container\Container;

final class QueryBus
{
    public function __construct(
        private Container $container
    ) {
    }

    public function execute(mixed $query): mixed
    {
        $handler = $this->resolveHandler($query);

        //@phpstan-ignore-next-line
        return $handler->handle($query);
    }

    private function resolveHandler(mixed $query): Handler
    {
        return $this->container->make($this->getHandlerName($query));
    }

    private function getHandlerName(mixed $query): string
    {
        /** @var string */
        $class = get_class($query);

        $handlerName = str_replace('Query', 'Handler', $class);

        return $handlerName;
    }
}
