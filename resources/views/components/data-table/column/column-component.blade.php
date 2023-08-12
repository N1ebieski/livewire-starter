<td
    {{ $attributes->merge([
        'class' => $display(),
    ])->filter(fn ($value) => is_string($value)) }}
>
    {{ $slot }}
</td>