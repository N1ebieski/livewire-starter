<?php

declare(strict_types=1);

namespace App\Livewire\Components\Web\User\Account;

use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Livewire\Components\Component;
use App\Livewire\Components\HasComponent;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

final class ChangePasswordComponent extends Component
{
    use HasComponent;
    use SendsPasswordResetEmails;

    public function submit(
        Translator $translator,
        UrlGenerator $urlGenerator,
        Session $session
    ): void {
        $this->gate->allowIf(fn () => $this->guard->check());

        /** @var User */
        $user = $this->guard->user();

        $this->sendResetLinkEmail(new Request(['email' => $user->email]));

        $this->dispatch('hide-modal', alias: $this->alias);

        $session->flash('resent', $translator->get('account.actions.change_password'));

        $this->guard->logout();

        $this->redirect($urlGenerator->route('login'));
    }

    public function render(): View
    {
        $this->gate->allowIf(fn () => $this->guard->check());

        return $this->viewFactory->make('livewire.web.user.account.change-password-component');
    }
}
