<?php

declare(strict_types=1);

namespace App\View\Metas\Admin;

use Illuminate\Support\Collection as Collect;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Translation\Translator as Trans;

abstract class MetaFactory
{
    public function __construct(
        protected Config $config,
        protected Trans $trans,
        protected Collect $collect,
        protected AdminMetaFactory $adminMetaFactory
    ) {
    }
}
