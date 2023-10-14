<td
    {{ $attributes->merge([
        'class' => $display(),
    ])->filter(fn ($value) => is_string($value)) }}
    x-on:click.self="toggleSelect(id)" 
>
    {{ $slot }}
</td>