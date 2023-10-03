<x-modal.layout.content-component>
    <x-slot:title>
        {{ trans('role.confirms.delete.single', ['name' => $role->name->value]) }}
    </x-slot:title>

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
            :action="\App\View\Components\Button\Action::DANGER"
            :label="trans('default.delete')"
            :responsive="false"
            wire:click="submit"
        >
            <x-slot:icon>
                <i class="bi bi-trash3"></i>
            </x-slot:icon>
        </x-button.button-component>
    </x-slot:footer>
</x-modal.layout.content-component>
