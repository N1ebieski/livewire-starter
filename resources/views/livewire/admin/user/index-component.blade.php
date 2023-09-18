<x-admin.layouts.app.panel-component>
    <x-slot:breadcrumb>
        <x-breadcrumb.item-component :active="true">
            {{ trans('user.pages.index.title') }}
        </x-breadcrumb.item-component>
    </x-slot:breadcrumb>

    {{-- <a href="{{ route('admin.home.index') }}" wire:navigate.hover>home</a> --}}
    
    <livewire:admin.data-tables.user.data-table-component />
</x-admin.layouts.app.panel-component>
