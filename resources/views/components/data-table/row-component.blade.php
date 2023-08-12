<tr
    id="row-{{ $value }}"
    x-on:click="toggleSelect('{{ $value }}')"
    {{ $attributes->class(['transition'])->filter(fn ($value) => is_string($value)) }}  
> 
    {{ $slot }}
</tr>