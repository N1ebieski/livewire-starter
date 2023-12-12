<div 
    x-data="{ id: $id('{{ $attributes->get('id') }}') }"
    @if(isset($parent))
    {{ $parent->attributes->class([
        'form-floating' => $labelFloating
    ])->filter(fn ($value) => is_string($value)) }}
    @else
    class="{{ $labelFloating ? 'form-floating' : '' }}"
    @endif
>
    @if(!$labelFloating && !is_null($label))
    <div
        @if(is_object($label))
        {{ $label->attributes->class([
            'form-label d-flex justify-content-between' => !isset($col),
            'col-form-label' => isset($col)
        ])->filter(fn ($value) => is_string($value)) }}
        @endif
        @if(is_string($label) && !isset($col))
        class="form-label d-flex justify-content-between"
        @endif
    >     
        <label :for="id">
            <span>{{ $label }}:</span>
        </label>
        @if(isset($tooltip))
        <x-tooltip.tooltip-component value="{{ $tooltip }}" />
        @endif
    </div>
    @endif
    @if(isset($col))
    <div
        {{ is_object($col) ? $col->attributes->filter(fn ($value) => is_string($value)) : '' }}
    >
    @endif  
        <input 
            type="search" 
            :id="id"
            {{ $attributes->class([
                'form-control',
                'highlight' => $errors->isEmpty() && $highlight,
                'is-invalid' => $errors->has($attributes->get('name')),
                'is-valid' => $errors->isNotEmpty() && !$errors->has($attributes->get('name'))
            ])->filter(fn ($value) => is_string($value)) }}
        >
        @if($highlight)
        <div>
            <span 
                wire:loading.remove 
                wire:target="{{ $getReset() }}"
                style="position:absolute;right:8px;top:11px"
            >
                <button 
                    type="button" 
                    class="btn-close" 
                    aria-label="{{ trans('default.close') }}"
                    wire:click="{{ $getReset() }}"
                ></button>
            </span>
            <span 
                class="d-none"
                wire:loading 
                wire:target="{{ $getReset() }}"
                wire:loading.class.remove="d-none"  
                style="position:absolute;right:14px;top:16px"      
            >
                <span 
                    class="spinner-border spinner-border-sm" 
                    role="status" 
                    aria-hidden="true"
                ></span>
                <span class="visually-hidden">{{ trans('default.loading') }}...</span>
            </span>             
        </div>
        @endif
        @if($labelFloating && !is_null($label))
        <label :for="id">
            @if($attributes->wire('model')?->hasModifier('live'))
            <span 
                class="d-none"
                wire:loading 
                wire:target="{{ $attributes->get('name') }}"
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
            <span>{{ $label }}</span> 
        </label>
        @endif 
        @error($attributes->get('name')) 
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror        
    @if(isset($col)) 
    </div>  
    @endif            
</div>