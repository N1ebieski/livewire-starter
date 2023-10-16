<div 
    x-data
    @if(isset($parent))
    {{ $parent->attributes->filter(fn ($value) => is_string($value)) }}
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
        <label for="{{ $attributes->get('id') }}">
            <span>{{ $label }}:</span>
        </label>
        @if(isset($tooltip))
        <x-tooltip.tooltip-component title="{{ $tooltip }}" />
        @endif
    </div>
    @endif
    @if(isset($col))
    <div
        {{ is_object($col) ? $col->attributes->filter(fn ($value) => is_string($value)) : '' }}
    >
    @endif
        <span 
            x-ref="valid"
            class="{{ $errors->has($attributes->get('name')) ? 
                'is-invalid' : ($errors->isNotEmpty() ? 'is-valid' : '') }}"
        >    
            <div  
                class="{{ $labelFloating ? 'form-floating' : '' }} autocomplete" 
                x-data="autoComplete({
                    @if($attributes->wire('model')->value())
                    value: @entangle($attributes->wire('model')),
                    @endif
                    endpoint: @js($endpoint),
                    except: @js($except),
                    validation: @js($validation),
                    highlight: @js($highlight),            
                    config: @js($autocomplete)
                })"
                x-on:livewire:navigating.window="dispose()"
                wire:ignore
            >         
                <input 
                    type="text" 
                    x-ref="autocomplete" 
                    autocomplete="off"
                    {{ $attributes->class(['form-control'])
                        ->filter(fn ($value, $key) => is_string($value) && !str_starts_with($key, 'wire:')) }} 
                >
                @if($labelFloating && !is_null($label))
                <label for="{{ $attributes->get('id') }}">
                    {{ $label }}:
                </label>
                @endif             
            </div>
        </span>
        @error($attributes->get('name')) 
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    @if(isset($col)) 
    </div>  
    @endif
</div>