<?php

declare(strict_types=1);

namespace App\View\Metas\Auth;

use App\View\Metas\MetaInterface;

class VerificationMetaFactory extends MetaFactory
{
    public function make(): MetaInterface
    {
        return $this->authMetaFactory->make(
            title: $this->trans->get('auth.pages.verify.title'),
            description: $this->trans->get('auth.pages.verify.description'),
            keywords: $this->trans->get('auth.pages.verify.keywords'),
        );
    }
}
