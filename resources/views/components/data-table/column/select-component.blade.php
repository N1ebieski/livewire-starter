<th 
    scope="row"
    {{ $attributes->filter(fn ($value) => is_string($value)) }}    
>
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
</th>                       