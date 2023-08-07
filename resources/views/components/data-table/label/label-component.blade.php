<th 
    scope="col" 
    {{ $attributes->merge([
        'class' => $display(),
    ])->filter(fn ($value) => is_string($value)) }}    
>
    <span class="align-bottom">{{ $slot }}</span>
    @if(in_array($name, $sorts))
    <span>
        @switch($value)
            @case("{$name}|asc")
                <button 
                    class="btn label highlight p-0 m-0"
                    wire:click="setOrderBy('{{ $name }}|desc')"
                >
                    <span 
                        wire:key="order-by-{{ $name }}-asc-show" 
                        wire:loading.remove wire:target="setOrderBy('{{ $name }}|desc')"
                    >
                        <i class="bi bi-sort-up"></i>
                    </span>
                    <span 
                        class="d-none" 
                        wire:key="order-by-{{ $name }}-asc-loading" 
                        wire:loading 
                        wire:loading.class.remove="d-none"
                        wire:target="setOrderBy('{{ $name }}|desc')"
                    >
                        <span 
                            class="spinner-border spinner-border-sm" 
                            role="status" 
                            aria-hidden="true"
                        ></span>
                        <span class="visually-hidden">{{ trans('default.loading') }}...</span>
                    </span>                    
                </button>
                @break

            @case("{$name}|desc")
                <button 
                    class="btn label highlight p-0 m-0" 
                    wire:click="setOrderBy(null)"
                >
                    <span 
                        wire:key="order-by-{{ $name }}-desc-show" 
                        wire:loading.remove 
                        wire:target="setOrderBy(null)"
                    >
                        <i class="bi bi-sort-down"></i>
                    </span>
                    <span 
                        class="d-none" 
                        wire:key="order-by-{{ $name }}-desc-loading" 
                        wire:loading 
                        wire:loading.class.remove="d-none"
                        wire:target="setOrderBy(null)"                      
                    >
                        <span 
                            class="spinner-border spinner-border-sm" 
                            role="status" 
                            aria-hidden="true"
                        ></span>
                        <span class="visually-hidden">{{ trans('default.loading') }}...</span>
                    </span>                       
                </button>
                @break

            @default
                <button 
                    class="btn label p-0 m-0" 
                    wire:click="setOrderBy('{{ $name }}|asc')"
                >
                    <span 
                        wire:key="order-by-{{ $name }}-null-show" 
                        wire:loading.remove 
                        wire:target="setOrderBy('{{ $name }}|asc')"
                    >
                        <i class="bi bi-filter-square"></i>
                    </span>
                    <span 
                        class="d-none" 
                        wire:key="order-by-{{ $name }}-null-sloading" 
                        wire:loading 
                        wire:loading.class.remove="d-none"
                        wire:target="setOrderBy('{{ $name }}|asc')"                 
                    >
                        <span 
                            class="spinner-border spinner-border-sm" 
                            role="status" 
                            aria-hidden="true"
                        ></span>
                        <span class="visually-hidden">{{ trans('default.loading') }}...</span>
                    </span>                      
                </button>
            @endswitch        
    </span>
    @endif
</th>