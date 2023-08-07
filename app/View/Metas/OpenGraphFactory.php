<?php

declare(strict_types=1);

namespace App\View\Metas;

use App\View\Metas\OpenGraphInterface;

abstract class OpenGraphFactory
{
    abstract public function make(
        string $title,
        string $description,
        string $type,
        string $image,
        string $url = null
    ): OpenGraphInterface;
}
