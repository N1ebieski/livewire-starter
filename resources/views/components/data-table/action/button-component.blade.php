<div class="btn-group"> 
    @if(!$lazy)
    <button
        type="button" 
        class="btn btn-{{ $action->value }}"
        wire:loading.attr="disabled"
        {{ $attributes->class([
            'btn', "btn-{$action->value}"
        ])->filter(fn ($value) => is_string($value)) }}
    >
        @if($icon)
        <span 
            wire:loading.remove 
            wire:target="{{ $targetsAsString }}"
        >
            {{ $icon }}
        </span>
        <span 
            class="d-none"
            wire:loading 
            wire:target="{{ $targetsAsString }}"
            wire:loading.class.remove="d-none" 
        >
            <span 
                class="spinner-border spinner-border-sm" 
                role="status" 
                aria-hidden="true"
            ></span>
            <span class="visually-hidden">{{ trans('default.loading') }}...</span>
        </span>
        @endif
        <span class="d-none d-md-inline">{{ $label }}</span>        
    </button>
    @if(isset($options))
    <button 
        type="button" 
        class="btn btn-{{ $action->value }} dropdown-toggle dropdown-toggle-split" 
        wire:loading.attr="disabled"
        data-bs-toggle="dropdown" 
        aria-expanded="false"
    >
        <span class="visually-hidden">{{ trans('default.toggle') }}</span>
    </button>
    <ul class="dropdown-menu">
        {{ $options }}
    </ul>
    @endif
    @else
    <x-data-table.placeholder-component style="width:100px;" />
    @endif    
</div>