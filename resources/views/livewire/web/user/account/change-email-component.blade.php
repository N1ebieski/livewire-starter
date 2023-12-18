<x-modal.layout.content-component>
    <x-slot:title>
        {{ trans('account.pages.change_email.title') }}
    </x-slot:title>

    <x-slot:body>
        <form wire:submit.prevent="submit" id="change-email">
            <div class="mb-3">
                <x-forms.email.email-component
                    wire:model="form.email"
                    :label="trans('user.email.label')"
                />
            </div>
            <div class="mb-3">
                <x-forms.password.password-component
                    x-data="{ first: true }"
                    x-on:focus="
                        if (first) {
                            $el.removeAttribute('readonly');
                            first = false;
                        }
                    "
                    wire:model="form.password"
                    x-bind:readonly="first"
                    :label="trans('user.password.label')"
                />
            </div>
        </form>       
    </x-slot:body>

    <x-slot:footer>
        <x-button.button-component
            :action="\App\View\Components\Button\Action::SECONDARY"
            :label="trans('default.cancel')"
            :responsive="false"
            data-bs-dismiss="modal"
        >
            <x-slot:icon>
                <i class="bi bi-x-circle"></i>
            </x-slot:icon>
        </x-button.button-component>
        <x-button.button-component
            :action="\App\View\Components\Button\Action::PRIMARY"
            :type="\App\View\Components\Button\Type::SUBMIT"
            :label="trans('default.submit')"
            :responsive="false"
            form="change-email"
            wire:click
        >
            <x-slot:icon>
                <i class="bi bi-check-circle"></i>
            </x-slot:icon>
        </x-button.button-component>
    </x-slot:footer>    
</x-modal.layout.content-component>