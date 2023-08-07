<div 
    tabindex="-1"
    aria-hidden="true"
    {{ $attributes->class([
        'modal', 'modal-blur', 'fade'
    ])->filter(fn ($value) => is_string($value)) }}
>
    <div class="
        modal-dialog 
        modal-dialog-centered 
        {{ $modal->scrollable ? 'modal-dialog-scrollable' : '' }} 
        {{ $modal->size ? $modal->size->value : '' }}
    ">
        {{ $slot }}
    </div>
</div>