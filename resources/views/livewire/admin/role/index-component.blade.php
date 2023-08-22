<x-admin.layouts.app.slot-component>
    <x-slot:breadcrumb>
        <x-breadcrumb.item-component :active="true">
            {{ trans('role.pages.index.title') }}
        </x-breadcrumb.item-component>
    </x-slot:breadcrumb>

    <livewire:admin.data-table.role.data-table-component />
</x-admin.layouts.app.slot-component>
