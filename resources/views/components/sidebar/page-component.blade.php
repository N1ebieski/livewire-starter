<a 
    {{ $attributes->class([
        'nav-link'
    ])->filter(fn ($value) => is_string($value) || $value === true) }}    
    @wireNavigate('hover')
    @if($active)
    aria-current="page"
    @endif
>
    @if($icon)
    <span class="me-1">{{ $icon }}</span>
    @endif
    <span>{{ $attributes->get('title') }}</span>
</a>