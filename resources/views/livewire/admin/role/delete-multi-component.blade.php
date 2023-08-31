<x-modal.layout.content-component>
    <x-slot:title>
        {{ trans_choice('role.confirms.delete.multi', count($this->roles), [
            'number' => count($this->roles)
        ]) }}
    </x-slot:title>

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
            :action="\App\View\Components\Buttons\Action::DANGER"
            :label="trans('default.delete')"
            :responsive="false"
            wire:click="submit"
        >
            <x-slot:icon>
                <i class="bi bi-trash3"></i>
            </x-slot:icon>
        </x-buttons.button-component>
    </x-slot:footer>
</x-modal.layout.content-component>
