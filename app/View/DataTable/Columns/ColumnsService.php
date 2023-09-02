<?php

declare(strict_types=1);

namespace App\View\DataTable\Columns;

use Illuminate\Contracts\Cookie\Factory as CookieFactory;
use Illuminate\Contracts\Cookie\QueueingFactory as CookieQueueingFactory;

final class ColumnsService
{
    public function __construct(
        private CookieFactory $cookieFactory,
        private ColumnsHelper $columnsHelper,
        private CookieQueueingFactory $cookieQueueingFactory
    ) {
    }

    public function createCookie(string $name, Columns $columns): void
    {
        $this->cookieQueueingFactory->queue(
            $this->cookieFactory->forever(
                name: $name,
                value: json_encode($columns->value)
            )
        );
    }

    public function removeCookie(string $name): void
    {
        $this->cookieQueueingFactory->queue(
            $this->cookieFactory->forget($name)
        );
    }
}
