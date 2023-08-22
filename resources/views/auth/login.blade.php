<x-web.layouts.app.app-component :meta="$meta">
    <x-web.layouts.app.slot-component>
        <x-auth.layouts.auth-component>
            <x-card.card-component>
                <x-slot:header>
                    <h5 class="py-2 m-0">{{ trans('auth.pages.login.title') }}</h5>
                </x-slot:header>

                <x-slot:body>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <x-forms.email-component
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
                            <x-forms.password-component
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
                            <x-forms.switch-component
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

                                <button type="submit" class="btn btn-primary">
                                    {{ trans('auth.login') }}
                                </button>

                                @if (app('router')->has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ trans('auth.reset') }}
                                </a>
                                @endif
                            </div>
                        </div>
                        <hr>
                        @if (app('router')->has('register'))
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <span class="me-1">
                                    {{ trans('auth.no_profile') }}
                                </span>
                                <a 
                                    class="btn btn-outline-primary" 
                                    href="{{ route('register') }}"
                                    title="{{ trans('auth.register') }}"
                                >
                                    {{ trans('auth.register') }}
                                </a>
                            </div>
                        </div>
                        @endif
                    </form>
                </x-slot:body>
            </x-card.card-component>
        </x-auth.layouts.auth-component>
    </x-web.layouts.app.slot-component>
</x-web.layouts.app-component>