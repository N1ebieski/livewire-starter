<div 
    class="btn-group"
    x-data="{ loading: false }"
    x-init="
        loading=false;
        Livewire.hook('commit', ({ respond }) => {
            respond(() => {
                loading = false;
            })            
        })
    "       
> 
    <button
        type="button" 
        x-bind:disabled="loading"
        x-on:click.stop="loading=true"
        {{ $attributes->class([
            'btn', "btn-{$action->value}"
        ])->filter(fn ($value) => is_string($value)) }}
    >
        @if($icon)
        <span x-show="!loading">
            {{ $icon }}
        </span>
        <span x-show="loading" x-cloak>
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