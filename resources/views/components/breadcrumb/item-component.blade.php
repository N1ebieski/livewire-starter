<li 
    {{ $attributes->class([
        'breadcrumb-item',
        'active' => $active
    ])->filter(fn ($value) => is_string($value)) }}
    @if($active)
    aria-current="page"
    @endif  
>
    {{ $slot }}
</li>