<div 
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
        <input 
            type="email" 
            {{ $attributes->class([
                'form-control',
                'is-invalid' => $errors->has($attributes->get('name')),
                'is-valid' => $errors->isNotEmpty() && !$errors->has($attributes->get('name'))
            ])->filter(fn ($value) => is_string($value)) }}
        >
        @if($labelFloating && !is_null($label))
        <label for="{{ $attributes->get('id') }}">
            {{ $label }}:
        </label>
        @endif 
        @error($attributes->get('name')) 
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    @if(isset($col)) 
    </div>  
    @endif
</div>