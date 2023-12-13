<?php

declare(strict_types=1);

namespace App\View\Metas\Auth;

use App\View\Metas\MetaInterface;

final class RegisterMetaFactory extends MetaFactory
{
    public function make(): MetaInterface
    {
        return $this->authMetaFactory->make(
            title: $this->translator->get('auth.pages.register.title'),
            description: $this->translator->get('auth.pages.register.description'),
            keywords: $this->translator->get('auth.pages.register.keywords'),
        );
    }
}
