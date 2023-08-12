<x-modal.content-component>
    <x-slot:title>
        {{ trans('user.page.edit.title', ['name' => $user->name]) }}
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
                        options: array_map(function ($enum) {
                            return [
                                'value' => $enum->value,
                                'text' => $enum->value
                            ];
                        }, \App\ValueObjects\Role\Name::cases()),
                        maxItems: count(\App\ValueObjects\Role\Name::cases()),
                        allowEmptyOption: false
                    )"
                    multiple="true"
                />
            </div>                      
        </form>
    </x-slot:body>    

    <x-slot:footer>
        <x-buttons.button-component
            :action="\App\View\Components\Action::SECONDARY"
            :label="trans('default.cancel')"
            :responsive="false"
            data-bs-dismiss="modal"
            :targets="['cancel']"
        >
            <x-slot:icon>
                <i class="bi bi-x-circle"></i>
            </x-slot:icon>
        </x-buttons.button-component>
        <x-buttons.button-component
            :action="\App\View\Components\Action::PRIMARY"
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