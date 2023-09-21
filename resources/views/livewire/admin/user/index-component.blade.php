<x-admin.layouts.app.slot-component>
    <div class="container-fluid">
        <x-admin.breadcrumb.breadcrumb-component>
            <x-breadcrumb.item-component :active="true">
                {{ trans('user.pages.index.title') }}
            </x-breadcrumb.item-component>
        </x-admin.breadcrumb.breadcrumb-component>
        
        <livewire:admin.data-tables.user.data-table-component />
    </div>
</x-admin.layouts.app.slot-component>
