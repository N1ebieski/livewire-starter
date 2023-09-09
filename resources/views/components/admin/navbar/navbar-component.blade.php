<nav 
    x-data="navbar({ autohide: @js($autohide) })"
    x-show="show"
    x-transition
    class="navbar navbar-expand bg-{{ $currentTheme }} fixed-top border-bottom"
>
    <div class="container-fluid">
        <button 
            class="navbar-toggler d-block me-2" 
            type="button" 
            aria-controls="sidebar"
            x-on:click.prevent="
                const offcanvas = bootstrap.Offcanvas.getInstance('#sidebar');

                offcanvas.toggle();
            "
        >
            <span class="navbar-toggler-icon"></span>
        </button>
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
            <li class="nav-item dropdown">
                <div class="px-1" style="padding-top:0.3rem;">
                    <button 
                        class="btn"
                        type="button" 
                        x-on:click="$dispatch('toggle-spotlight')"
                    >
                        <i class="bi bi-search" style="font-size: 1.3rem"></i>
                    </button>
                </div>
            </li>
            <x-multi-theme.multi-theme-component />
            <x-admin.navbar.dropdown.dropdown-component>
                <x-slot:icon>
                    <i class="bi bi-person-fill-gear" style="font-size: 1.5rem"></i>
                </x-slot:icon>

                <h6 class="dropdown-header">
                    {{ trans('auth.hello')}}, {{ auth()->user()->name }}!
                </h6>
                <div class="dropdown-divider"></div>
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
        </ul>
    </div>
</nav>