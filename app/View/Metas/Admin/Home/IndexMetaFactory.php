<?php

declare(strict_types=1);

namespace App\View\Metas\Admin\Home;

use App\View\Metas\MetaInterface;
use App\View\Metas\Admin\MetaFactory;

class IndexMetaFactory extends MetaFactory
{
    public function make(): MetaInterface
    {
        return $this->adminMetaFactory->make();
    }
}
