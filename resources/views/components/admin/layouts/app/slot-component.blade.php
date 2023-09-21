<div>
    <x-admin.navbar.navbar-component />
    <div class="navbar-height"></div>

    <div class="wrapper">
        <x-admin.sidebar.sidebar-component />

        <div class="content-wrapper">
            <div class="content">
                {{ $slot }}
            </div>

            <x-admin.footer.footer-component />
        </div>
    </div>

    <x-toast.toast-component />
    <x-scroll-to-top.scroll-to-top-component />

    <livewire:modal.modal-component />
    
    <livewire:livewire-ui-spotlight />

    <div id="dropdowns" wire:ignore></div>
</div>