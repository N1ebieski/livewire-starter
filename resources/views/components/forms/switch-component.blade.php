<div
    x-data
    {{ $parent->attributes->filter(fn ($value) => is_string($value)) }}    
>
    @if(isset($col))
    <div 
        {{ is_object($col) ? $col->attributes->filter(fn ($value) => is_string($value)) : '' }}
    >
    @endif
        <div class="form-check form-switch">
            <input 
                type="checkbox" 
                role="switch"             
                {{ $attributes->class([
                    'form-check-input',
                    'is-invalid' => $errors->has($attributes->get('name')),
                    'is-valid' => $errors->isNotEmpty() && !$errors->has($attributes->get('name'))
                ])->filter(fn ($value) => is_string($value) || $value === true) }}                    
            >
            <label 
                for="{{ $attributes->get('id') }}" 
                @if(is_object($label))
                {{ $label->attributes->class([
                    'form-check-label d-flex justify-content-between' => !isset($col),
                    'col-form-label' => isset($col)
                ])->filter(fn ($value) => is_string($value)) }}
                @endif
                @if(is_string($label) && !isset($col))
                class="form-check-label d-flex justify-content-between"
                @endif        
            >
                <span>{{ $label }}</span>
                @if(isset($tooltip))
                <x-tooltip.tooltip-component title="{{ $tooltip }}" />
                @endif
            </label>
            @error($attributes->get('name')) 
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    @if(isset($col)) 
    </div>
    @endif
</div>
