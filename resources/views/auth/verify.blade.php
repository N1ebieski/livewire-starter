<x-web.layouts.app.app-component :meta="$meta">
    <x-web.layouts.app.landing-page-component>
        <x-auth.layouts.auth-component>
            <x-card.card-component>
                <x-slot:header>
                    <h5 class="py-2 m-0">{{ trans('auth.pages.verify.title') }}</h5>
                </x-slot:header>

                <x-slot:body>
                    @if (session('resent'))
                    <x-alert.alert-component
                        :action="\App\View\Components\Alert\Action::SUCCESS"
                        :close="false"
                    >
                        {{ trans('auth.action.verify') }}
                    </x-alert.alert-component>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},

                    <form 
                        class="d-inline" 
                        method="POST" 
                        action="{{ route('verification.resend') }}"
                    >
                        @csrf

                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                            {{ __('click here to request another') }}
                        </button>.
                    </form>
                </x-slot:body>
            </x-card.card-component>
        </x-auth.layouts.auth-component>
    </x-web.layouts.app.landing-page-component>
</x-web.layouts.app.app-component>
