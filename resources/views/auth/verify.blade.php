<x-web.layouts.app.app-component :meta="$meta">
    <x-web.layouts.app.slot-component>
        <x-auth.layout.auth-component>
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
                        {{ trans('auth.messages.verify') }}
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

                        <x-button.button-component
                            :action="\App\View\Components\Button\Action::LINK"
                            :label="__('click here to request another')"
                            :responsive="false"
                            :type="\App\View\Components\Button\Type::SUBMIT"
                            class="p-0 m-0 align-top"
                        >
                            <x-slot:parent class="d-inline"></x-slot:parent>
                        </x-button.button-component>                        
                    </form>
                </x-slot:body>
            </x-card.card-component>
        </x-auth.layout.auth-component>
    </x-web.layouts.app.slot-component>
</x-web.layouts.app.app-component>
