<nav 
    aria-label="sidebar"
    x-data="sidebar({ show: @js($sidebar->show) })"
    x-on:livewire:navigating="destroy()"
    class="sidebar-wrapper d-none d-lg-block {{ $sidebar->show ? 'show' : '' }}"
    :class="{ 'show': show, 'd-none': !display, 'd-lg-block': !display }"
    wire:ignore
>
    <div 
        class="sidebar offcanvas offcanvas-start d-none d-lg-block {{ $sidebar->show ? 'show' : '' }}" 
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
                {{ trans('admin.title') }}
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
                <x-sidebar.item-component
                    :active="$routeHelper->isCurrentRoute('admin.home.index')"
                >
                    <x-sidebar.page-component
                        :active="$routeHelper->isCurrentRoute('admin.home.index')"
                        href="{{ route('admin.home.index') }}"
                        title="Dashboard"
                    >
                        <x-slot:icon>
                            <i class="bi bi-speedometer2"></i>
                        </x-slot:icon>
                    </x-sidebar.page-component>
                </x-sidebar.item-component>
                @endcan                                          
                @canAny([
                    'admin.user.view',
                    'admin.role.view'
                ])
                <x-sidebar.item-component
                    :active="$routeHelper->isCurrentRoute([
                        'admin.user.index',
                        'admin.role.index'
                    ])"
                >                
                    <x-sidebar.dropdown.dropdown-component
                        :active="$routeHelper->isCurrentRoute([
                            'admin.user.index',
                            'admin.role.index'
                        ])"
                        title="{{ trans('user.pages.index.title') }}"
                    >
                        <x-slot:icon>
                            <i class="bi bi-people-fill"></i>
                        </x-slot:icon>
                        @can('admin.user.view')
                        <x-sidebar.dropdown.item-component
                            :active="$routeHelper->isCurrentRoute('admin.user.index')"
                            href="{{ route('admin.user.index') }}"
                            title="{{ trans('user.pages.index.title') }}"
                        />
                        @endcan
                        @can('admin.role.view')
                        <x-sidebar.dropdown.item-component
                            :active="$routeHelper->isCurrentRoute('admin.role.index')"
                            href="{{ route('admin.role.index') }}"
                            title="{{ trans('role.pages.index.title') }}"
                        />
                        @endcan                    
                    </x-sidebar.dropdown.dropdown-component>
                </x-sidebar.item-component>    
                @endcan                                                                            
            </ul>
            <ul class="navbar-nav justify-content-end flex-grow-1 position-absolute bottom-0">
                @can('admin.home.view')
                <x-sidebar.item-component
                    :active="$routeHelper->isCurrentRoute('admin.sandbox.index')"
                >                
                    <x-sidebar.page-component
                        :active="$routeHelper->isCurrentRoute('admin.sandbox.index')"
                        href="{{ route('admin.sandbox.index') }}"
                        title="Sandbox"
                    >
                        <x-slot:icon>
                            <i class="bi bi-code-square"></i>
                        </x-slot:icon>
                    </x-sidebar.item-component>
                </x-sidebar.item-component>
                @endcan 
            </ul>                
        </div>
    </div>
</nav>