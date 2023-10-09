<?php

declare(strict_types=1);

namespace App\View\Metas\Auth;

use App\View\Metas\MetaInterface;

final class VerificationMetaFactory extends MetaFactory
{
    public function make(): MetaInterface
    {
        return $this->authMetaFactory->make(
            title: $this->translator->get('auth.pages.verify.title'),
            description: $this->translator->get('auth.pages.verify.description'),
            keywords: $this->translator->get('auth.pages.verify.keywords'),
        );
    }
}
