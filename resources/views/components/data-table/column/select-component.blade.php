<th 
    scope="row"
    {{ $attributes->filter(fn ($value) => is_string($value)) }}    
>
    @if(!$lazy)
    <div class="form-check">
        <input 
            class="form-check-input"
            type="checkbox" 
            value="{{ $value }}" 
            id="select-{{ $value }}"
            aria-label="{{ trans('data-table.select') }} {{ $value }}"
            x-model="selects"
        >      
    </div>    
    @else
    <x-data-table.placeholder-component />
    @endif                        
</th>