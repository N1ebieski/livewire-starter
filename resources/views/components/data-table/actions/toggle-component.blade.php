 <div>
    <div 
        class="form-check form-switch" 
        wire:loading.remove
        wire:target="{{ $targetsAsString }}"
    >
        <input 
            class="form-check-input" 
            type="checkbox" 
            role="switch" 
            aria-label="{{ trans('default.toggle') }}"
            {{ $attributes->class([
                'btn', 'btn-'
            ])->filter(fn ($value) => is_string($value)) }}          
        >
    </div>
    <span 
        wire:loading 
        wire:target="{{ $targetsAsString }}"
    >
        <span 
            class="spinner-border text-primary" 
            role="status" 
            aria-hidden="true"
        ></span>
        <span class="visually-hidden">{{ trans('default.loading') }}...</span>
    </span>     
</div>

