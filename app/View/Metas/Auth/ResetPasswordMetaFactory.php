<?php

declare(strict_types=1);

namespace App\View\Metas\Auth;

use App\View\Metas\MetaInterface;

class ResetPasswordMetaFactory extends MetaFactory
{
    public function make(): MetaInterface
    {
        return $this->authMetaFactory->make(
            title: $this->trans->get('auth.pages.reset.title'),
            description: $this->trans->get('auth.pages.reset.description'),
            keywords: $this->trans->get('auth.pages.reset.keywords'),
        );
    }
}
