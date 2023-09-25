<x-modal.layout.content-component>
    <x-slot:title>
        {{ trans('account.pages.change_email.title') }}
    </x-slot:title>

    <x-slot:body>
        <form wire:submit.prevent="submit">
            <div class="mb-3">
                <x-forms.email-component
                    wire:model="form.email"
                    :label="trans('user.email.label')"
                />
            </div>
            <div class="mb-3">
                <x-forms.password-component
                    x-data
                    x-on:focus="$el.removeAttribute('readonly')"
                    wire:model="form.password"
                    :readonly="true"
                    :label="trans('user.password.label')"
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
</x-modal.layout.content-component>