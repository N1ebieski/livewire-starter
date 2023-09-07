<div 
    x-data="sidebar({ show: @js($sidebarToggle) })"
    x-on:livewire:navigating="destroy()"
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
                @can('admin.home.view')
                <x-admin.sidebar.item-component
                    :active="$isCurrentRoute('admin.home.index')"
                    href="{{ route('admin.home.index') }}"
                    title="Dashboard"
                >
                    <x-slot:icon>
                        <i class="bi bi-speedometer2"></i>
                    </x-slot:icon>
                </x-admin.sidebar.item-component>
                @endcan                                          
                @canAny([
                    'admin.user.view',
                    'admin.role.view'
                ])
                <x-admin.sidebar.dropdown.dropdown-component
                    :active="$isCurrentRoute([
                        'admin.user.index',
                        'admin.role.index'
                    ])"
                    title="{{ trans('user.pages.index.title') }}"
                >
                    <x-slot:icon>
                        <i class="bi bi-people-fill"></i>
                    </x-slot:icon>
                    @can('admin.user.view')
                    <x-admin.sidebar.dropdown.item-component
                        :active="$isCurrentRoute('admin.user.index')"
                        href="{{ route('admin.user.index') }}"
                        title="{{ trans('user.pages.index.title') }}"
                    />
                    @endcan
                    @can('admin.role.view')
                    <x-admin.sidebar.dropdown.item-component
                        :active="$isCurrentRoute('admin.role.index')"
                        href="{{ route('admin.role.index') }}"
                        title="{{ trans('role.pages.index.title') }}"
                    />
                    @endcan                    
                </x-admin.sidebar.dropdown.dropdown-component>
                @endcan                                                                            
            </ul>
            <ul class="navbar-nav justify-content-end flex-grow-1 position-absolute bottom-0">
                @can('admin.home.view')
                <x-admin.sidebar.item-component
                    :active="$isCurrentRoute('admin.sandbox.index')"
                    href="{{ route('admin.sandbox.index') }}"
                    title="Sandbox"
                >
                    <x-slot:icon>
                        <i class="bi bi-code-square"></i>
                    </x-slot:icon>
                </x-admin.sidebar.item-component>
                @endcan 
            </ul>                
        </div>
    </div>
</div>