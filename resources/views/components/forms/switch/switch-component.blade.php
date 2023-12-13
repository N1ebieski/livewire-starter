<div
    x-data="{ id: $id('{{ $attributes->get('id') }}') }"
    @if(isset($parent))
    {{ $parent->attributes->filter(fn ($value) => is_string($value)) }}    
    @endif
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
                :id="id"             
                {{ $attributes->class([
                    'form-check-input',
                    'is-invalid' => $errors->has($attributes->get('name')),
                    'is-valid' => $errors->isNotEmpty() && !$errors->has($attributes->get('name'))
                ])->filter(fn ($value) => is_string($value) || $value === true) }}                    
            >
            <div 
                @if(is_object($label))
                {{ $label->attributes->class([
                    'd-flex justify-content-between' => !isset($col),
                    'col-form-label' => isset($col)
                ])->filter(fn ($value) => is_string($value)) }}
                @endif
                @if(is_string($label) && !isset($col))
                class="d-flex justify-content-between"
                @endif        
            >
                <label class="form-check-label" :for="id">
                    <span>{{ $label }}</span>
                </label>
                @if(isset($tooltip))
                <x-tooltip.tooltip-component value="{{ $tooltip }}" />
                @endif
            </div>
            @error($attributes->get('name')) 
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    @if(isset($col)) 
    </div>
    @endif
</div>
