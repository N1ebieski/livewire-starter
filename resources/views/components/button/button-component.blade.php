<div 
    @if(isset($parent))
    {{ $parent->attributes->class([
        'btn-group'
    ])->filter(fn ($value) => is_string($value)) }}
    @else
    class="btn-group"
    @endif
    x-data="{ loading: false }"
    x-on:livewire:commit:respond.window="loading=false"      
> 
    <{{ $type->getElement() }}
        @if($attributes->has('wire:click'))
        x-bind:disabled="loading"
        x-on:click.stop="loading=true"
        @endif
        {{ $attributes->class([
            'btn', 
            "btn-{$action?->value}" => !is_null($action)
        ])->filter(fn ($value) => is_string($value) || $value === true) }}
    >
        @if(isset($icon))
        <span 
            {{ $icon->attributes->filter(fn ($value) => is_string($value)) }}
            @if($attributes->has('wire:click'))
            x-show="!loading"
            @endif
        >
            {{ $icon }}
        </span>
        @if($attributes->has('wire:click'))
        <span 
            {{ $icon->attributes->filter(fn ($value) => is_string($value)) }}
            x-show="loading" 
            x-cloak
        >
            <span 
                class="spinner-border spinner-border-sm" 
                role="status" 
                aria-hidden="true"
            ></span>
            <span class="visually-hidden">{{ trans('default.loading') }}...</span>
        </span>
        @endif
        @endif
        @if(isset($label))
        <span 
            @if(is_object($label))
            {{ $label->attributes->class([
                'd-none d-md-inline' => $responsive
            ])->filter(fn ($value) => is_string($value)) }}
            @endif
        >
            {{ $label }}
        </span>
        @endif 
    </{{ $type->getElement() }}>
    @if(isset($options))
    <button 
        type="button" 
        class="btn {{ !is_null($action) ? 'btn-' . $action->value : '' }} dropdown-toggle dropdown-toggle-split" 
        data-bs-toggle="dropdown" 
        data-bs-reference="parent"
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