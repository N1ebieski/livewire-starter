<x-breadcrumb.breadcrumb-component>
    <x-breadcrumb.item-component :active="$slot->isEmpty()">
        <a href="{{ route('admin.home.index') }}" title="Dashboard">
            Dashboard
        </a>
    </x-breadcrumb.item-component>
    {{ $slot }}
</x-breadcrumb.breadcrumb-component>