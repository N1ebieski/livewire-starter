<x-breadcrumb.layout.breadcrumb-component>
    <x-breadcrumb.item-component :active="$slot->isEmpty()">
        <a 
            href="{{ route('admin.home.index') }}" 
            title="Dashboard"
            wire:navigate.hover="true"
        >
            Dashboard
        </a>
    </x-breadcrumb.item-component>
    {{ $slot }}
</x-breadcrumb.layout.breadcrumb-component>