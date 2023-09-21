<li 
    {{ $attributes->class([
        'nav-item', 
        'my-1', 
        'my-lg-auto',
        'active' => $active
    ])->filter(fn ($value) => is_string($value)) }}
>
    {{ $slot }}
</li>