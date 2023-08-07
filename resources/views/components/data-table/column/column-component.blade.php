<td
    {{ $attributes->merge([
        'class' => $display(),
    ])->filter(fn ($value) => is_string($value)) }}
>
    @if(!$lazy)
    <span>{{ $value }}</span>
    @else
    <x-data-table.placeholder-component />
    @endif
</td>