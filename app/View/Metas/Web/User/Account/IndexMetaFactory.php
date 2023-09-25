<?php

declare(strict_types=1);

namespace App\View\Metas\Web\User\Account;

use App\View\Metas\MetaInterface;
use App\View\Metas\Web\User\MetaFactory;

final class IndexMetaFactory extends MetaFactory
{
    public function make(): MetaInterface
    {
        return $this->userMetaFactory->make(
            title: $this->trans->get('account.pages.index.title'),
            description: $this->trans->get('account.pages.index.description'),
            keywords: $this->trans->get('account.pages.index.keywords'),
        );
    }
}
