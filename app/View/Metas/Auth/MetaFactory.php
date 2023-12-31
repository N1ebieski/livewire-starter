<?php

declare(strict_types=1);

namespace App\View\Metas\Auth;

use Illuminate\Support\Collection as Collect;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\Config\Repository as Config;

abstract class MetaFactory
{
    public function __construct(
        protected Config $config,
        protected Translator $translator,
        protected Collect $collect,
        protected AuthMetaFactory $authMetaFactory
    ) {
    }
}
