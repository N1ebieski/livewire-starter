 <div
    x-data="{ loading: false }"
    x-on:livewire:commit:respond.window="loading=false"
 >
    <div 
        class="form-check form-switch" 
        x-show="!loading"
    >
        <input 
            class="form-check-input" 
            type="checkbox" 
            role="switch" 
            :id="$id('toggle')"
            aria-label="{{ trans('default.toggle') }}"
            x-on:click.stop="loading=true"
            {{ $attributes->filter(fn ($value) => is_string($value) || $value === true) }}
        >
    </div>
    <span x-show="loading" x-cloak>
        <span 
            class="spinner-border text-primary" 
            role="status" 
            aria-hidden="true"
        ></span>
        <span class="visually-hidden">{{ trans('default.loading') }}...</span>
    </span>     
</div>
