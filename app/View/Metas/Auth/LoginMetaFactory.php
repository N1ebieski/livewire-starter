<?php

declare(strict_types=1);

namespace App\View\Metas\Auth;

use App\View\Metas\MetaInterface;

final class LoginMetaFactory extends MetaFactory
{
    public function make(): MetaInterface
    {
        return $this->authMetaFactory->make(
            title: $this->translator->get('auth.pages.login.title'),
            description: $this->translator->get('auth.pages.login.description'),
            keywords: $this->translator->get('auth.pages.login.keywords'),
        );
    }
}
