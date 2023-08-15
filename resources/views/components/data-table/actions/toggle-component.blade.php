 <div>
    <div 
        class="form-check form-switch" 
        wire:loading.remove
        wire:target="{{ $getTargetsAsString }}"
    >
        <input 
            class="form-check-input" 
            type="checkbox" 
            role="switch" 
            aria-label="{{ trans('default.toggle') }}"
            {{ $attributes->filter(fn ($value) => is_string($value)) }}
            @if($attributes->get('checked'))
            checked
            @endif
        >
    </div>
    <span 
        class="d-none"
        wire:loading 
        wire:target="{{ $getTargetsAsString }}"
        wire:loading.class.remove="d-none" 
    >
        <span 
            class="spinner-border text-primary" 
            role="status" 
            aria-hidden="true"
        ></span>
        <span class="visually-hidden">{{ trans('default.loading') }}...</span>
    </span>     
</div>
