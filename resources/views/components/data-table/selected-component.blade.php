<div
    {{ $attributes->merge([
        'class' => 'align-self-center'
    ])->filter(function ($value, $key) { 
        return is_string($value) && !in_array($key, ['collection']);
    }) }}     
>
    @if(!$lazy)
    <p class="p-0 m-0">
        {!! trans('data-table.selected', ['select' => 0, 'total' => $collection->total()]) !!}:
    </p>
    @else
    <x-data-table.placeholder-component style="width:100px;" />
    @endif
</div>