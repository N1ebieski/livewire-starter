<div>
    <div class="wrapper">
        <x-admin.navbar.navbar-component />
        <x-admin.sidebar.sidebar-component />

        <div class="content-wrapper">
            <div class="navbar-height"></div>

            <div class="container-fluid">
                <x-admin.breadcrumb.breadcrumb-component>
                    {{ $breadcrumb ?? null }}
                </x-admin.breadcrumb.breadcrumb-component>

                {{ $slot }}
            </div>
        </div>

        <x-admin.footer.footer-component />
    </div>

    <x-toast.toast-component />
    <x-scroll-to-top.scroll-to-top-component />

    <livewire:modal.modal-component />
    
    <livewire:livewire-ui-spotlight />

    <div id="dropdowns" wire:ignore></div>
</div>