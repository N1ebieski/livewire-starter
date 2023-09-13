<?php

namespace App\Spotlight\Admin\User;

use App\Spotlight\Command;
use LivewireUI\Spotlight\Spotlight;
use Illuminate\Contracts\Auth\Access\Gate;
use App\Extends\Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\Auth\Guard as BaseGuard;

/**
 * @property-read Guard $guard
 */
class IndexCommand extends Command
{
    public function __construct(
        protected Gate $gate,
        protected BaseGuard $guard,
        protected Translator $translator
    ) {
        $this->name = $this->translator->get('user.pages.index.title');
    }

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.user.index', navigate: true);
    }

    public function shouldBeShown(): bool
    {
        return $this->guard->user()?->can('admin.user.view') ?? false;
    }
}