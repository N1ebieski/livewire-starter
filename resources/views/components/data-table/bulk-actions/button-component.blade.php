<div 
    x-data="bulkAction"
    class="text-nowrap btn-group"
> 
    <button
        {{ $attributes->class([
            'btn', "btn-{$action->value}"
        ])->filter(fn ($value) => is_string($value)) }}  
        type="button" 
        x-bind:disabled="loading"
        x-show="show"
        x-cloak
        x-transition
    >
        @if(isset($icon))
        <span x-show="!loading">
            {{ $icon }}
        </span>
        <span x-show="loading">
            <span 
                class="spinner-border spinner-border-sm" 
                role="status" 
                aria-hidden="true"
            ></span>
            <span class="visually-hidden">{{ trans('default.loading') }}...</span>
        </span>
        @endif
        <span class="{{ $responsive ? 'd-none d-md-inline' : '' }}">
            {{ $label }}
        </span>        
    </button> 
    @if(isset($options))
    <button 
        type="button" 
        class="btn btn-{{ $action->value }} dropdown-toggle dropdown-toggle-split" 
        x-bind:disabled="loading"
        data-bs-toggle="dropdown" 
        aria-expanded="false"
    >
        <span class="visually-hidden">{{ trans('default.toggle') }}</span>
    </button>
    <ul class="dropdown-menu">
        {{ $options }}
    </ul>
    @endif     
</div>