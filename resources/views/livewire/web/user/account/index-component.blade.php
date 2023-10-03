<x-web.layouts.app.slot-component :sidebarAlias="'web.user.sidebar.sidebar-component'">
    <div class="container-lg">
        <x-web.user.breadcrumb.breadcrumb-component>
            <x-breadcrumb.item-component :active="true">
                {{ trans('account.pages.index.title') }}
            </x-breadcrumb.item-component>
        </x-web.user.breadcrumb.breadcrumb-component>

        <form wire:submit.prevent="submit">
            <div class="mb-3">
                <x-forms.text-component
                    wire:model="form.name"
                    :label="trans('user.name.label')"
                >
                    <x-slot:label class="col-md-4 text-md-end">
                        {{ trans('user.name.label') }}
                    </x-slot:label>
                    <x-slot:parent class="row"></x-slot:parent>
                    <x-slot:col class="col-md-6"></x-slot:col>
                </x-form.email-component>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <x-button.button-component
                        :action="\App\View\Components\Button\Action::PRIMARY"
                        :label="trans('default.submit')"
                        :responsive="false"
                        wire:click="submit"
                    >
                        <x-slot:icon>
                            <i class="bi bi-check-circle"></i>
                        </x-slot:icon>
                    </x-button.button-component>                    
                </div>
            </div>

            <hr>

            <div class="form-group row mb-3">
                <div class="col-form-label col-md-4 text-md-end">
                    {{ trans('user.password.label') }}:
                </div>
                <div class="col-md-6">
                    <x-button.button-component
                        :action="\App\View\Components\Button\Action::OUTLINE_PRIMARY"
                        :label="trans('account.change_password')"
                        :responsive="false"
                        wire:click="changePassword()"
                    >
                        <x-slot:icon>
                            <i class="bi bi-shield-check"></i>
                        </x-slot:icon>
                    </x-button.button-component>                    
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col-form-label col-md-4 text-md-end">
                    {{ trans('user.email.label') }}:
                </div>
                <div class="col-md-6">
                    <x-button.button-component
                        :action="\App\View\Components\Button\Action::OUTLINE_PRIMARY"
                        :label="trans('account.change_email')"
                        :responsive="false"
                        wire:click="changeEmail()"
                    >
                        <x-slot:icon>
                            <i class="bi bi-shield-check"></i>
                        </x-slot:icon>
                    </x-button.button-component>                    
                </div>
            </div>                                   
        </form>        
    </div>    
</x-web.layouts.app.slot-component>