<nav 
    x-data="navbar({ autohide: @js($autohide) })"
    x-show="show"
    x-on:click.outside="hideCollapse()"
    x-transition
    class="navbar navbar-expand-md bg-{{ $currentTheme }} fixed-top border-bottom"
    wire:ignore
>
    <div class="container-fluid">
        <x-admin.navbar.toggler-component
            class="me-2 d-block"
            x-on:click.prevent="toggleSidebar()"
            aria-label="{{ trans('default.sidebar_toggle') }}"
        />
        <a 
            href="{{ route('admin.home.index') }}"
            class="navbar-brand"
            title="{{ config('app.name') }}"
        >
            <img 
                src="{{ asset('images/logo.svg') }}" 
                class="mx-1 mb-2 logo d-inline" 
                alt="{{ config('app.name_short') }}" 
                title="{{ config('app.name') }}"
            >
            <span class="d-none d-md-inline">{{ config('app.name_short') }}</span>
        </a>
        <ul class="navbar-nav ms-auto">
            <x-admin.navbar.item-component>
                <div class="px-1" style="padding-top:0.1rem;">
                    <button 
                        class="btn"
                        type="button" 
                        x-on:click.prevent="toggleSpotlight()"
                    >
                        <i class="bi bi-search" style="font-size: 1.4rem"></i>
                    </button>
                </div>
            </x-admin.navbar.item-component>
        </ul>
        <x-admin.navbar.toggler-component
            class="ms-md-2"
            x-on:click.prevent="toggleCollapse()"
            aria-label="{{ trans('default.navbar_toggle') }}"
        />            
        <div 
            class="collapse navbar-collapse flex-grow-0" 
            x-ref="collapse"
        >
            <ul class="navbar-nav navbar-nav-scroll">
                <x-admin.navbar.item-component>
                    <x-multi-theme.multi-theme-component />
                </x-admin.navbar.item-component>
                <x-admin.navbar.item-component>
                    <x-admin.navbar.dropdown.dropdown-component>
                        <x-slot:icon>
                            <i class="bi bi-person-fill-gear" style="font-size: 1.5rem"></i>
                        </x-slot:icon>

                        <x-slot:title class="d-inline d-md-none">
                            {{ auth()->user()->name }}
                        </x-slot:title>

                        <h6 class="dropdown-header d-md-block d-none">
                            {{ trans('auth.hello')}}, {{ auth()->user()->name }}!
                        </h6>
                        <div class="dropdown-divider d-md-block d-none"></div>
                        <form 
                            class="d-inline" 
                            method="POST" 
                            action="{{ route('logout') }}"
                        >
                            @csrf

                            <button type="submit" class="btn btn-link dropdown-item">
                                {{ trans('auth.logout') }}
                            </button>
                        </form>
                    </x-admin.navbar.dropdown.dropdown-component>
                </x-admin.navbar.item-component>
            </ul>
        </div> 
    </div>
</nav>