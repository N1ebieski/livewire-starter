<div 
    x-data="{
        show: true,
        display: false
    }"
    x-init="
        if (window.innerWidth < 768) {
            show = false;
        } else if (window.innerWidth < 992) {
            show = false;
        }

        display = true;
    "
>
    <div class="d-flex justify-content-end mb-2">
        <button
            type="button" 
            class="btn btn-outline-dark btn-sm {{ $isDirty ? 'highlight' : '' }}"
            x-on:click="show = !show"
        >
            <i class="bi bi-funnel"></i>
            <span>Filtry</span>
            <span x-show="!show" x-cloak>
                <i class="bi bi-caret-down-fill"></i>
            </span>
            <span x-show="show" x-cloak>
                <i class="bi bi-caret-up-fill"></i>
            </span>
        </button>
    </div>
    <div 
        class="d-none d-lg-block"
        x-bind:class="{ 'd-none': !display, 'd-lg-block': !display }"
        x-show="show"
        x-collapse
    >
        {{ $slot }}
    </div>
</div>