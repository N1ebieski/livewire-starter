<x-web.layouts.app.app-component :meta="$meta">
    <x-web.layouts.app.slot-component>
        <x-auth.layout.auth-component>
            <x-card.card-component>
                <x-slot:header>
                    <h5 class="py-2 m-0">{{ trans('auth.pages.register.title') }}</h5>
                </x-slot:header>

                <x-slot:body>
                    <form method="POST" action="{{ route('register') }}" id="register">
                        @csrf

                        <div class="mb-3">
                            <x-forms.text.text-component
                                name="name"
                                id="name"
                                :label="trans('auth.name.label')"
                                :value="old('name')"
                            >
                                <x-slot:label class="col-md-4 text-md-end">
                                    {{ trans('auth.name.label') }}
                                </x-slot:label>
                                <x-slot:parent class="row"></x-slot:parent>
                                <x-slot:col class="col-md-6"></x-slot:col>
                            </x-forms.text.text-component>
                        </div>                            

                        <div class="mb-3">
                            <x-forms.email.email-component
                                name="email"
                                id="email"
                                :label="trans('auth.address.label')"
                                :value="old('email')"
                            >
                                <x-slot:label class="col-md-4 text-md-end">
                                    {{ trans('auth.address.label') }}
                                </x-slot:label>
                                <x-slot:parent class="row"></x-slot:parent>
                                <x-slot:col class="col-md-6"></x-slot:col>
                            </x-forms.email.email-component>
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
                            </x-forms.password.password-component>  
                        </div>                                                  

                        <div class="mb-3">    
                            <x-forms.password.password-component
                                name="password_confirmation"
                                id="password_confirmation"
                                :label="trans('auth.password')"
                            >
                                <x-slot:label class="col-md-4 text-md-end">
                                    {{ trans('auth.password_confirm') }}
                                </x-slot:label>
                                <x-slot:parent class="row"></x-slot:parent>
                                <x-slot:col class="col-md-6"></x-slot:col>
                            </x-forms.password.password-component>
                        </div>                            

                        <div class="mb-3">
                            <x-forms.switch.switch-component
                                name="privacy_agreement"
                                id="privacy_agreement"
                                label=""
                                :checked="old('privacy_agreement')"
                            >
                                <x-slot:label class="pt-0">
                                    <small>{!! trans('policy.agreement.privacy', ['privacy' => str_slug(trans('policy.privacy'))]) !!}</small>
                                </x-slot:label>
                                <x-slot:parent class="row"></x-slot:parent>
                                <x-slot:col class="col-md-6 offset-md-4"></x-slot:col>
                            </x-forms.switch.switch-component>
                        </div>

                        <div class="mb-3">
                            <x-forms.switch.switch-component
                                name="contact_agreement"
                                id="contact_agreement"
                                label=""
                                :checked="old('contact_agreement')"
                            >
                                <x-slot:label class="pt-0">
                                    <small>{{ trans('policy.agreement.register') }}</small>
                                </x-slot:label>
                                <x-slot:parent class="row"></x-slot:parent>
                                <x-slot:col class="col-md-6 offset-md-4"></x-slot:col>
                            </x-forms.switch.switch-component>
                        </div>                            

                        <div class="mb-3">
                            <x-forms.switch.switch-component
                                name="marketing_agreement"
                                id="marketing_agreement"
                                label=""
                                :checked="old('marketing_agreement')"
                            >
                                <x-slot:label class="pt-0">
                                    <small>{{ trans('policy.agreement.marketing') }}</small>
                                </x-slot:label>
                                <x-slot:parent class="row"></x-slot:parent>
                                <x-slot:col class="col-md-6 offset-md-4"></x-slot:col>
                            </x-forms.switch.switch-component>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <x-button.button-component
                                    :action="\App\View\Components\Button\Action::PRIMARY"
                                    :label="trans('auth.register')"
                                    :responsive="false"
                                    :type="\App\View\Components\Button\Type::SUBMIT"
                                />
                            </div>
                        </div>
                    </form>
                </x-slot:body>
            </x-card.card-component>
        </x-auth.layouts.auth-component>
    </x-web.layouts.app.slot-component>
</x-web.layouts.app-component>
