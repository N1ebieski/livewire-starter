 <div
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
    <div 
        class="form-check form-switch" 
        x-show="!loading"
    >
        <input 
            class="form-check-input" 
            type="checkbox" 
            role="switch" 
            aria-label="{{ trans('default.toggle') }}"
            x-on:click.stop="loading=true"
            {{ $attributes->filter(fn ($value) => is_string($value)) }}
            @if($attributes->get('checked'))
            checked
            @endif
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
