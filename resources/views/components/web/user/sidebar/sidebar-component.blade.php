<nav
    aria-label="sidebar"
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
                {{ trans('user.title') }}
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
                <x-sidebar.item-component
                    :active="$isCurrentRoute('web.user.account.index')"
                >
                    <x-sidebar.page-component
                        :active="$isCurrentRoute('web.user.account.index')"
                        href="{{ route('web.user.account.index') }}"
                        title="{{ trans('account.pages.show.title') }}"
                    >
                        <x-slot:icon>
                            <i class="bi bi-person-fill-gear"></i>
                        </x-slot:icon>
                    </x-sidebar.page-component>
                </x-sidebar.item-component>                                                                                            
            </ul>            
        </div>
    </div>
</nav>