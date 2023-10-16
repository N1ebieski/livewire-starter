<x-web.layouts.app.app-component :meta="$meta">
    <x-web.layouts.app.slot-component>
        <x-auth.layout.auth-component>
            <x-card.card-component>
                <x-slot:header>
                    <h5 class="py-2 m-0">{{ trans('auth.pages.login.title') }}</h5>
                </x-slot:header>

                <x-slot:body>
                    @if (session('resent'))
                    <x-alert.alert-component
                        :action="\App\View\Components\Alert\Action::SUCCESS"
                        :close="false"
                    >
                        {{ session('resent') }}
                    </x-alert.alert-component>
                    @endif 

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <x-forms.email.email-component
                                name="email"
                                id="email"
                                :label="trans('auth.address.label')"
                            >
                                <x-slot:label class="col-md-4 text-md-end">
                                    {{ trans('auth.address.label') }}
                                </x-slot:label>
                                <x-slot:parent class="row"></x-slot:parent>
                                <x-slot:col class="col-md-6"></x-slot:col>
                            </x-form.email-component>
                        </div>

                        <div class="mb-3">
                            <x-forms.password.password-component
                                name="password"
                                id="password"
                                :label="trans('auth.password')"
                            >
                                <x-slot:label class="col-md-4 text-md-end">
                                    {{ trans('auth.password') }}
                                </x-slot:label>
                                <x-slot:parent class="row"></x-slot:parent>
                                <x-slot:col class="col-md-6"></x-slot:col>
                            </x-form.email-component>
                        </div>

                        <div class="mb-3">
                            <x-forms.switch.switch-component
                                name="remember"
                                id="remember"
                                :label="trans('auth.remember')"
                                :checked="old('remember')"
                            >
                                <x-slot:parent class="row"></x-slot:parent>
                                <x-slot:col class="col-md-6 offset-md-4"></x-slot:col>
                            </x-form.switch-component>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <input 
                                    type="hidden" 
                                    name="redirect" 
                                    value="{{ old('redirect', url()->previous() ?? null) }}"
                                >

                                <div class="d-flex">
                                    <x-button.button-component
                                        :action="\App\View\Components\Button\Action::PRIMARY"
                                        :label="trans('auth.login')"
                                        :responsive="false"
                                        :type="\App\View\Components\Button\Type::SUBMIT"
                                    />

                                    @if (app('router')->has('password.request'))
                                    <x-button.button-component
                                        :action="\App\View\Components\Button\Action::LINK"
                                        :label="trans('auth.reset')"
                                        :responsive="false"
                                        :type="\App\View\Components\Button\Type::A"
                                        href="{{ route('password.request') }}"
                                    />
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr>
                        @if (app('router')->has('register'))
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <span class="me-1 align-middle">
                                    {{ trans('auth.no_profile') }}
                                </span>
                                <x-button.button-component
                                    :action="\App\View\Components\Button\Action::OUTLINE_PRIMARY"
                                    :label="trans('auth.register')"
                                    :responsive="false"
                                    :type="\App\View\Components\Button\Type::A"
                                    href="{{ route('register') }}"
                                >
                                    <x-slot:parent class="d-inline"></x-slot:parent>
                                </x-button.button-component>
                            </div>
                        </div>
                        @endif
                    </form>
                </x-slot:body>
            </x-card.card-component>
        </x-auth.layouts.auth-component>
    </x-web.layouts.app.slot-component>
</x-web.layouts.app-component>