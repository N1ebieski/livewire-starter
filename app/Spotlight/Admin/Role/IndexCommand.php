<?php

namespace App\Spotlight\Admin\Role;

use App\Spotlight\Command;
use LivewireUI\Spotlight\Spotlight;
use Illuminate\Contracts\Auth\Access\Gate;
use App\Extends\Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\Auth\Guard as BaseGuard;

/**
 * @property-read Guard $guard
 */
final class IndexCommand extends Command
{
    public function __construct(
        protected Gate $gate,
        protected BaseGuard $guard,
        protected Translator $translator
    ) {
        $this->name = $this->translator->get('role.pages.index.title');
    }

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.role.index', navigate: true);
    }

    public function shouldBeShown(): bool
    {
        return $this->guard->user()?->can('admin.role.view') ?? false;
    }
}
