<th 
    scope="col" 
    {{ $attributes->merge([
        'style' => 'min-width:40px;'
    ])->filter(fn ($value) => is_string($value)) }}    
>
    @if(!$lazy)
    <div class="form-check">
        <input 
            class="form-check-input"
            type="checkbox" 
            aria-label="{{ trans('data-table.select_all') }}"
            x-on:click="toggleSelectAll"
            x-model="selectAll"
        >
    </div>   
    @else
    <x-data-table.placeholder-component />
    @endif                               
</th>