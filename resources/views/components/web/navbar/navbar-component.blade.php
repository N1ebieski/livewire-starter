<nav 
    aria-label="navbar"
    x-data="navbar({ autohide: @js($autohide) })"
    x-show="show"
    x-on:click.outside="hideCollapse()"
    x-transition
    class="navbar navbar-expand-lg bg-{{ $currentTheme->name }} fixed-top border-bottom"
    wire:ignore
>
    <div class="container-fluid">
        @if($sidebar)
        <x-navbar.toggler-component
            class="me-2 d-block"
            x-on:click.prevent="toggleSidebar()"
            aria-label="{{ trans('default.sidebar_toggle') }}"
        />
        @endif
        <a 
            href="{{ route('web.home.index') }}"
            class="navbar-brand"
            title="{{ config('app.name') }}"
        >
            <img 
                src="{{ asset('images/logo.svg') }}" 
                class="mx-1 mb-2 logo d-inline" 
                alt="{{ config('app.name_short') }}" 
                title="{{ config('app.name') }}"
            >
            <span class="d-none d-lg-inline">{{ config('app.name_short') }}</span>
        </a>
        <ul class="navbar-nav ms-auto">
            <x-navbar.item-component>
                <div class="px-1 px-lg-0" style="padding-top:0.1rem;">
                    <x-buttons.button-component
                        :action="null"
                        x-on:click.prevent="toggleSpotlight()"
                    >
                        <x-slot:icon>
                            <i class="bi bi-search" style="font-size: 1.4rem"></i>
                        </x-slot:icon>
                    </x-buttons.button-component>
                </div>
            </x-navbar.item-component>
        </ul>
        <x-navbar.toggler-component
            class="ms-lg-2"
            x-on:click.prevent="toggleCollapse()"
            aria-label="{{ trans('default.navbar_toggle') }}"
        />            
        <div 
            class="collapse navbar-collapse flex-grow-0" 
            x-ref="collapse"
        >
            <ul class="navbar-nav navbar-nav-scroll">
                <x-navbar.item-component>
                    <x-multi-theme.multi-theme-component />
                </x-navbar.item-component>
                <x-navbar.item-component>
                    @if(auth()->check())
                    <x-navbar.dropdown.dropdown-component>
                        <x-slot:icon>
                            <i class="bi bi-person-fill-gear" style="font-size: 1.5rem"></i>
                        </x-slot:icon>

                        <x-slot:title class="d-inline d-lg-none">
                            {{ auth()->user()->name }}
                        </x-slot:title>

                        <h6 class="dropdown-header d-lg-block d-none">
                            {{ trans('auth.hello')}}, {{ auth()->user()->name }}!
                        </h6>
                        @auth
                        <x-navbar.dropdown.item-component
                            :active="$routeHelper->isCurrentRouteStartsWith('web.user.')"
                            href="{{ route('web.user.account.index') }}"
                            title="{{ trans('user.title') }}"
                        />
                        @endauth                         
                        @can('admin.access')
                        <x-navbar.dropdown.item-component
                            :active="$routeHelper->isCurrentRouteStartsWith('admin.')"
                            href="{{ route('admin.home.index') }}"
                            title="{{ trans('admin.title') }}"
                        />
                        @endcan                        
                        <div class="dropdown-divider d-lg-block d-none"></div>
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
                    </x-navbar.dropdown.dropdown-component>
                    @else
                    <x-buttons.button-component
                        class="btn btn-outline-primary text-nowrap text-center text-primary ms-lg-1" 
                        href="{{ route('login') }}" 
                        title="{{ trans('auth.login') }}"                    
                        label="{{ trans('auth.login') }}"
                        :action="\App\View\Components\Buttons\Action::OUTLINE_PRIMARY"
                        :type="\App\View\Components\Buttons\Type::A"
                        :responsive="false"
                    >
                        <x-slot:parent class="d-flex d-lg-inline-flex"></x-slot:parent>
                    </x-buttons.button-component>
                    @endif                    
                </x-navbar.item-component>
            </ul>
        </div> 
    </div>
</nav>