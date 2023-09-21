<div>
    <x-web.navbar.navbar-component :sidebar="isset($sidebarAlias)" />
    <div class="navbar-height"></div>

    <div class="wrapper">
        @if(isset($sidebarAlias))
        <x-dynamic-component :component="$sidebarAlias" />
        @endif

        <div class="content-wrapper">
            <div class="content">
                {{ $slot }}
            </div>

            <x-web.footer.footer-component />   
        </div>     
    </div>

    <x-toast.toast-component />
    <x-scroll-to-top.scroll-to-top-component />

    <livewire:modal.modal-component />

    <livewire:livewire-ui-spotlight />

    <div id="dropdowns" wire:ignore></div>    
</div>