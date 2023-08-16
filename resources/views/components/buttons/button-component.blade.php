<div 
    class="btn-group"
    x-data="{ loading: false }"
    x-on:livewire:commit:respond.window="loading=false"      
> 
    <button
        type="button" 
        @if($attributes->has('wire:click'))
        x-bind:disabled="loading"
        x-on:click.stop="loading=true"
        @endif
        {{ $attributes->class([
            'btn', "btn-{$action->value}"
        ])->filter(fn ($value) => is_string($value)) }}
    >
        @if($icon)
        <span 
            @if($attributes->has('wire:click'))
            x-show="!loading"
            @endif
        >
            {{ $icon }}
        </span>
        @if($attributes->has('wire:click'))
        <span x-show="loading">
            <span 
                class="spinner-border spinner-border-sm" 
                role="status" 
                aria-hidden="true"
            ></span>
            <span class="visually-hidden">{{ trans('default.loading') }}...</span>
        </span>
        @endif
        @endif
        <span class="{{ $responsive ? 'd-none d-md-inline' : '' }}">
            {{ $label }}
        </span>        
    </button>
    @if(isset($options))
    <button 
        type="button" 
        class="btn btn-{{ $action->value }} dropdown-toggle dropdown-toggle-split" 
        data-bs-toggle="dropdown" 
        aria-expanded="false"
        @if($attributes->has('wire:click'))
        x-bind:disabled="loading"
        @endif
    >
        <span class="visually-hidden">{{ trans('default.toggle') }}</span>
    </button>
    <ul class="dropdown-menu">
        {{ $options }}
    </ul>
    @endif   
</div>