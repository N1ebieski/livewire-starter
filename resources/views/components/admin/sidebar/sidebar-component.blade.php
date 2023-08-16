<div 
    x-data="sidebar({ show: @js($sidebarToggle) })"
    class="sidebar-wrapper d-none d-lg-block {{ $sidebarToggle ? 'show' : '' }}"
    :class="{ 'show': show, 'd-none': !display, 'd-lg-block': !display }"
    wire:ignore
>
    <div 
        class="sidebar offcanvas offcanvas-start d-none d-lg-block {{ $sidebarToggle ? 'show' : '' }}" 
        :class="{ 'show': show, 'd-none': !display, 'd-lg-block': !display }"
        tabindex="-1" 
        id="sidebar" 
        aria-labelledby="sidebar-label"
        x-ref="sidebar"
    >
        <div class="offcanvas-header">
            <h5 
                class="offcanvas-title" 
                id="sidebar-label"
            >
                {{ trans('default.menu') }}
            </h5>
            <button 
                type="button" 
                class="btn-close" 
                data-bs-dismiss="offcanvas" 
                aria-label="{{ trans('default.close') }}"
            ></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1">
                {{-- @can('admin.home.view') --}}
                <x-admin.sidebar.item-component
                    :active="$isCurrentRoute('admin.home.index')"
                    href="{{ route('admin.home.index') }}"
                    title="Dashboard"
                    wire:navigate.hover="true"
                >
                    <x-slot:icon>
                        <i class="bi bi-speedometer2"></i>
                    </x-slot:icon>
                </x-admin.sidebar.item-component>
                {{-- @endcan                                           --}}
                {{-- @can('admin.user.view') --}}
                <x-admin.sidebar.dropdown.dropdown-component
                    :active="$isCurrentRoute('admin.user.index')"
                    title="{{ trans('user.pages.index.title') }}"
                >
                    <x-slot:icon>
                        <i class="bi bi-people-fill"></i>
                    </x-slot:icon>
                    {{-- @can('admin.user.view') --}}
                    <x-admin.sidebar.dropdown.item-component
                        :active="$isCurrentRoute('admin.user.index')"
                        href="{{ route('admin.user.index') }}"
                        title="{{ trans('user.pages.index.title') }}"
                        wire:navigate.hover="true"
                    />
                    {{-- @endcan --}}
                </x-admin.sidebar.dropdown.dropdown-component>
                {{-- @endcan                                           --}}                
            </ul>
        </div>
    </div>
</div>