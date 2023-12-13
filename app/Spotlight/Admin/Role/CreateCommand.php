<?php

namespace App\Spotlight\Admin\Role;

use App\Spotlight\Command;
use LivewireUI\Spotlight\Spotlight;
use App\ValueObjects\Role\DefaultName;
use Illuminate\Contracts\Auth\Access\Gate;
use App\Extends\Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Translation\Translator;
use App\Livewire\Components\Modal\ModalComponent;
use Illuminate\Contracts\Auth\Guard as BaseGuard;
use App\View\Components\Modal\Modal as BootstrapModal;

/**
 * @property-read Guard $guard
 */
final class CreateCommand extends Command
{
    public function __construct(
        protected Gate $gate,
        protected BaseGuard $guard,
        protected Translator $translator
    ) {
        $this->name = "{$this->translator->get('role.pages.index.title')}: {$this->translator->get('default.create')}";
    }

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->dispatch(
            'create-modal',
            alias: 'admin.role.create-component',
            modal: new BootstrapModal(
                static: true,
                scrollable: true
            )
        )->to(ModalComponent::class);
    }

    public function shouldBeShown(): bool
    {
        return $this->guard->user()?->hasRole(DefaultName::SUPER_ADMIN->value) ?? false;
    }
}
