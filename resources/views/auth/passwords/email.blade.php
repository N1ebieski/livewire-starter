<x-web.layouts.app.app-component :meta="$meta">
    <x-web.layouts.app.slot-component>
        <x-auth.layout.auth-component>
            <x-card.card-component>
                <x-slot:header>
                    <h5 class="py-2 m-0">{{ trans('auth.pages.reset.title') }}</h5>
                </x-slot:header>                                

                <x-slot:body>
                    @if (session('status'))
                    <x-alert.alert-component
                        :action="\App\View\Components\Alert\Action::SUCCESS"
                        :close="false"
                    >
                        {{ session('status') }}
                    </x-alert.alert-component>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

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

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <x-button.button-component
                                    :action="\App\View\Components\Button\Action::PRIMARY"
                                    :label="trans('auth.submit_reset')"
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
