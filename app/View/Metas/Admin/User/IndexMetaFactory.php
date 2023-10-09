<?php

declare(strict_types=1);

namespace App\View\Metas\Admin\User;

use App\View\Metas\MetaInterface;
use App\View\Metas\Admin\MetaFactory;

final class IndexMetaFactory extends MetaFactory
{
    public function make(?int $page = null): MetaInterface
    {
        return $this->adminMetaFactory->make(
            title: $this->translator->get('user.pages.index.title'),
            page: $page,
            description: $this->translator->get('user.pages.index.description'),
            keywords: $this->translator->get('user.pages.index.keywords'),
        );
    }
}
