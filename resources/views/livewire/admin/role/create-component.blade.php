<x-modal.layout.content-component>
    <x-slot:title>
        {{ trans('role.pages.create.title') }}
    </x-slot:title>

    <x-slot:body>
        <form wire:submit.prevent="submit" id="create-role">
            <div class="mb-3">
                <x-forms.text.text-component
                    wire:model="form.name"
                    :label="trans('role.name.label')"
                />
            </div>
            <div class="mb-3">
                <x-forms.tomselect.tomselect-component
                    wire:model="form.permissions"
                    :label="trans('role.permissions.label')"
                    :tomselect="new \App\View\Components\Forms\Tomselect\Tomselect(
                        options: $this->groupedPermissions->map(function ($permission) {
                            return [
                                'value' => $permission->id,
                                'text' => $permission->name,
                                'optgroup' => $permission->optgroup
                            ];
                        })->toArray(),
                        optgroups: $this->groupedPermissions->pluck('optgroup')->map(function ($optgroup) {
                            return [
                                'value' => $optgroup,
                                'label' => $optgroup,
                            ];
                        })->toArray(),
                        maxItems: $this->groupedPermissions->count(),
                        allowEmptyOption: false
                    )"
                    multiple="true"
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
            form="create-role"
            wire:click
        >
            <x-slot:icon>
                <i class="bi bi-check-circle"></i>
            </x-slot:icon>
        </x-button.button-component>
    </x-slot:footer>    
</x-modal.layout.content-component>