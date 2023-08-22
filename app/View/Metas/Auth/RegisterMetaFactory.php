<?php

declare(strict_types=1);

namespace App\View\Metas\Auth;

use App\View\Metas\MetaInterface;

class RegisterMetaFactory extends MetaFactory
{
    public function make(): MetaInterface
    {
        return $this->authMetaFactory->make(
            title: $this->trans->get('auth.pages.register.title'),
            description: $this->trans->get('auth.pages.register.description'),
            keywords: $this->trans->get('auth.pages.register.keywords'),
        );
    }
}
