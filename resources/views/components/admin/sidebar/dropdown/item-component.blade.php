<li>
    <a 
        {{ $attributes->class([
            'dropdown-item', 'active' => $active
        ])->filter(fn ($value) => is_string($value)) }}
        @wireNavigate('hover')
        @if($active)
        aria-current="page"
        @endif
    >
        {{ $attributes->get('title') }}
    </a>
</li>