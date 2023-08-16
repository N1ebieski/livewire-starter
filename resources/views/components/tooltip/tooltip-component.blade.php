<div
    x-data
    x-init="new bootstrap.Tooltip(document.querySelector($refs.tooltip))"
    wire:ignore
>
    <a 
        href="javascript:void(0)"
        x-ref="tooltip"  
        {{ $attributes->merge([
            'class' => 'text-reset',
            'data-bs-toggle' => 'tooltip',
            'data-bs-placement' => 'left',
            'title' => $value,
        ])->filter(fn ($value) => is_string($value)) }}      
    >         
        <i class="bi bi-question-square"></i>
    </a>
</div>