<x-modal.content-component>
    <x-slot:title>
        {{ trans('user.pages.create.title') }}
    </x-slot:title>

    <x-slot:body>
        <form wire:submit.prevent="submit">
            <div class="mb-3">
                <x-forms.text-component
                    wire:model="form.name"
                    :label="trans('user.name.label')"
                />
            </div>
            <div class="mb-3">
                <x-forms.email-component
                    wire:model="form.email"
                    :label="trans('user.email.label')"
                />
            </div>
            <div class="mb-3">
                <x-forms.password-component
                    wire:model="form.password"
                    :label="trans('user.password.label')"
                />
            </div>
            <div class="mb-3">
                <x-forms.password-component
                    wire:model="form.password_confirmation"
                    :label="trans('user.password_confirmation.label')"
                />  
            </div>
            <div class="mb-3">
                <x-forms.tomselect.tomselect-component
                    wire:model="form.roles"
                    :label="trans('user.roles.label')"
                    :tomselect="new \App\View\Components\Forms\Tomselect\Tomselect(
                        options: $this->roles->map(function ($role) {
                            return [
                                'value' => $role->id,
                                'text' => $role->name
                            ];
                        })->toArray(),
                        maxItems: $this->roles->count(),
                        allowEmptyOption: false
                    )"
                    multiple="true"
                />
            </div>                      
        </form>
    </x-slot:body>    

    <x-slot:footer>
        <x-buttons.button-component
            :action="\App\View\Components\Buttons\Action::SECONDARY"
            :label="trans('default.cancel')"
            :responsive="false"
            data-bs-dismiss="modal"
        >
            <x-slot:icon>
                <i class="bi bi-x-circle"></i>
            </x-slot:icon>
        </x-buttons.button-component>
        <x-buttons.button-component
            :action="\App\View\Components\Buttons\Action::PRIMARY"
            :label="trans('default.submit')"
            :responsive="false"
            wire:click="submit"
        >
            <x-slot:icon>
                <i class="bi bi-check-circle"></i>
            </x-slot:icon>
        </x-buttons.button-component>
    </x-slot:footer>    
</x-modal.content-component>