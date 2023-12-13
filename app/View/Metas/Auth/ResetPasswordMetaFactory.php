<?php

declare(strict_types=1);

namespace App\View\Metas\Auth;

use App\View\Metas\MetaInterface;

final class ResetPasswordMetaFactory extends MetaFactory
{
    public function make(): MetaInterface
    {
        return $this->authMetaFactory->make(
            title: $this->translator->get('auth.pages.reset.title'),
            description: $this->translator->get('auth.pages.reset.description'),
            keywords: $this->translator->get('auth.pages.reset.keywords'),
        );
    }
}
