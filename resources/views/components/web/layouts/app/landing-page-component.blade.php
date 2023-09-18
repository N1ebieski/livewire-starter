<div>
    <div class="wrapper">
        <x-web.navbar.navbar-component />

        <div class="content-wrapper">
            <div class="navbar-height"></div>

            {{ $slot }}
        </div>
    </div>

    <livewire:modal.modal-component />
</div>