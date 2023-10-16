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
                class="{{ $labelFloating ? 'form-floating' : '' }}" 
                x-data="tomSelect({
                    @if($attributes->wire('model')->value())
                    value: @entangle($attributes->wire('model')),
                    @endif
                    lang: @js($lang),
                    endpoint: @js($endpoint),
                    except: @js($except),
                    validation: @js($validation),
                    highlight: @js($highlight),                      
                    config: @js($tomselect)
                })"
                x-on:livewire:navigating.window="dispose()"
                wire:ignore
            >
                @if($type->isEquals(\App\View\Components\Forms\Tomselect\Type::SELECT))
                <select 
                    x-ref="tomselect"
                    {{ $attributes->class(['form-select'])
                        ->filter(fn ($value, $key) => is_string($value) && !str_starts_with($key, 'wire:')) }} 
                >
                    {{ $slot ?? '' }}
                </select>
                @elseif($type->isEquals(\App\View\Components\Forms\Tomselect\Type::INPUT))
                <input 
                    type="text"
                    x-ref="tomselect" 
                    {{ $attributes->class(['form-control'])
                        ->filter(fn ($value, $key) => is_string($value) && !str_starts_with($key, 'wire:')) }} 
                >
                @endif       
                @if($labelFloating && !is_null($label))
                <label for="{{ $attributes->get('id') }}">
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
                    <span>{{ $label }}:</span>
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