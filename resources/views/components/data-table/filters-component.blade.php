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
    <div class="d-flex justify-content-end mb-2 gap-2">
        @if($isDirty)
        <x-button.button-component
            :action="\App\View\Components\Button\Action::OUTLINE_DARK"
            :label="trans('default.clear')"
            :responsive="false"
            class="btn-sm highlight"
            wire:click="clear"
        >
            <x-slot:icon>
                <i class="bi bi-x-square"></i>
            </x-slot:icon>
        </x-button.button-component>
        @endif
        <x-button.button-component
            :action="\App\View\Components\Button\Action::OUTLINE_DARK"
            :label="trans_choice('filter.filters', 2)"
            :responsive="false"
            class="btn-sm"
            x-on:click="show = !show"
        >
            <x-slot:icon>
                <i class="bi bi-funnel"></i>
            </x-slot:icon>
            <x-slot:label>
                <span>{{ trans_choice('filter.filters', 2) }}</span>
                <span x-show="!show" x-cloak>
                    <i class="bi bi-chevron-down"></i>
                </span>
                <span x-show="show" x-cloak>
                    <i class="bi bi-chevron-up"></i>
                </span>                
            </x-slot:label>
        </x-button.button-component>
    </div>
    <div 
        class="d-none d-lg-block"
        x-bind:class="{ 'd-none': !display, 'd-lg-block': !display }"
        x-show="show"
        x-collapse
        x-on:focusin="show ? $el.style.overflow = null : ''"
    >
        {{ $slot }}
    </div>
</div>