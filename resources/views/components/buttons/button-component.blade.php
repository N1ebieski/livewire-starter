<div 
    @if(isset($parent))
    {{ $parent->attributes->class([
        'btn-group'
    ])->filter(fn ($value) => is_string($value)) }}
    @endif
    x-data="{ loading: false }"
    x-on:livewire:commit:respond.window="loading=false"      
> 
    <{{ $type->value }}
        @if($type->isEquals(\App\View\Components\Buttons\Type::BUTTON))
        type="button"
        @elseif($type->isEquals(\App\View\Components\Buttons\Type::A))
        role="button"
        @endif
        @if($attributes->has('wire:click'))
        x-bind:disabled="loading"
        x-on:click.stop="loading=true"
        @endif
        {{ $attributes->class([
            'btn', 
            "btn-{$action?->value}" => !is_null($action)
        ])->filter(fn ($value) => is_string($value)) }}
    >
        @if(isset($icon))
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
        @if(isset($label))
        <span class="{{ $responsive ? 'd-none d-md-inline' : '' }}">
            {{ $label }}
        </span>
        @endif 
    </{{ $type->value }}>
    @if(isset($options))
    <button 
        type="button" 
        class="btn {{ !is_null($action) ? 'btn-' . $action->value : '' }} dropdown-toggle dropdown-toggle-split" 
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