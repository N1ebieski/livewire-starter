<li
    class="nav-item my-1 {{ $active ? 'active' : '' }}"
>
    <a 
        {{ $attributes->class([
            'nav-link', 'disabled' => $disabled
        ])->filter(fn ($value) => is_string($value)) }}    
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
</li>