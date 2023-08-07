<tr 
    @if(!$lazy)
    id="row-{{ $value }}"
    x-on:click="toggleSelect('{{ $value }}')"
    @endif
    {{ $attributes->merge([
        'class' => 'transition',
    ])->filter(fn ($value) => is_string($value)) }}    
>
    {{ $slot }}
</tr>