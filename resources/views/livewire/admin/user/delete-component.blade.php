<x-modal.content-component>
    <x-slot:title>
        {{ trans('user.confirm.delete.single', ['name' => $this->user->name]) }}
    </x-slot:title>

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
            :action="\App\View\Components\Action::DANGER"
            :label="trans('default.delete')"
            :responsive="false"
            wire:click="submit"
        >
            <x-slot:icon>
                <i class="bi bi-trash3"></i>
            </x-slot:icon>
        </x-buttons.button-component>
    </x-slot:footer>
</x-modal.content-component>
