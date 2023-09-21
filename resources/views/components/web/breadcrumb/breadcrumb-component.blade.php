<x-breadcrumb.layout.breadcrumb-component>
    <x-breadcrumb.item-component :active="$slot->isEmpty()">
        <a 
            href="{{ route('web.home.index') }}" 
            title="{{ trans('home.pages.index.title') }}"
            @wireNavigate('hover')
        >
            {{ trans('home.pages.index.title') }}
        </a>
    </x-breadcrumb.item-component>
    {{ $slot }}
</x-breadcrumb.layout.breadcrumb-component>