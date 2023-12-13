<?php

declare(strict_types=1);

namespace App\Livewire\Components\Web\User\Account;

use App\Models\User\User;
use App\Commands\CommandBus;
use Illuminate\Contracts\View\View;
use App\Livewire\Components\Component;
use Illuminate\Support\ValidatedInput;
use App\Commands\User\Edit\EditCommand;
use App\Livewire\Components\HasComponent;
use App\Livewire\Components\FullPageInterface;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Translation\Translator;
use App\Livewire\Components\Modal\ModalComponent;
use App\Livewire\Forms\Web\User\Account\IndexForm;
use App\View\Metas\Web\User\Account\IndexMetaFactory;
use App\Extends\Illuminate\Contracts\Auth\Access\Gate;
use App\View\Components\Modal\Modal as BootstrapModal;

/**
 * @property-read Gate $gate
 * @property IndexForm $form
 */
final class IndexComponent extends Component implements FullPageInterface
{
    use HasComponent;

    public IndexForm $form;

    public function mount(): void
    {
        /** @var User|null */
        $user = $this->guard->user();

        $this->form->name = $user?->name;
    }

    public function submit(
        CommandBus $commandBus,
        Translator $translator,
        UrlGenerator $urlGenerator
    ): void {
        $this->gate->allowIf(fn () => $this->guard->check());

        /** @var ValidatedInput&IndexForm */
        $validated = $this->form->safe();

        /** @var User */
        $user = $this->guard->user();

        /** @var User */
        $user = $commandBus->execute(
            new EditCommand(
                user: $user,
                name: $validated->name, //@phpstan-ignore-line
                email: $user->email,
                password: $user->password,
                roles: $user->roles
            )
        );

        $this->dispatch(
            'create-toast',
            body: $translator->get('account.messages.account', ['name' => $user->name])
        );

        $this->redirect($urlGenerator->route('web.user.account.index'), true);
    }

    public function changePassword(): void
    {
        $this->dispatch(
            'create-modal',
            alias: 'web.user.account.change-password-component',
            modal: new BootstrapModal(),
        )->to(ModalComponent::class);
    }

    public function changeEmail(): void
    {
        $this->dispatch(
            'create-modal',
            alias: 'web.user.account.change-email-component',
            modal: new BootstrapModal(static: true),
        )->to(ModalComponent::class);
    }

    public function render(IndexMetaFactory $metaFactory): View
    {
        $this->gate->allowIf(fn () => $this->guard->check());

        $meta = $metaFactory->make();

        return $this->viewFactory->make('livewire.web.user.account.index-component')
            ->layout('components.web.layouts.app.app-component', compact('meta'));
    }
}
