<li 
    {{ $attributes->class([
        'nav-item'
    ])->filter(fn ($value) => is_string($value)) }}
>
    {{ $slot }}
</li>