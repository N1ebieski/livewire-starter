<div 
    x-data
    @if(isset($parent))
    {{ $parent->attributes->filter(fn ($value) => is_string($value)) }}
    @endif
>
    @if(!is_null($label))
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
                x-data="tinyMCE({
                    @if($attributes->wire('model')->value())
                    value: @entangle($attributes->wire('model')),
                    @endif
                    config: @js($tinymce)
                })"
                x-on:tinymce:load.window="init()"
                x-on:livewire:navigating.window="dispose()"
                wire:ignore
            >
                <textarea 
                    x-ref="tinymce"
                    {{ $attributes->class(['form-control'])
                        ->filter(fn ($value, $key) => is_string($value) && !str_starts_with($key, 'wire:')) }}        
                ></textarea>
            </div>
        </span>
        @error($attributes->get('name')) 
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    @if(isset($col)) 
    </div>  
    @endif        
</div>

@pushOnce('head-scripts')
<script data-load="tinymce" src="{{ asset('build/assets/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>     
@endPushOnce