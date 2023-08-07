<li 
    class="nav-item my-1 dropdown {{ $active ? 'active' : '' }}"
>
    <a 
        {{ $attributes->class([
            'nav-link', 'dropdown-toggle'
        ])->filter(fn ($value) => is_string($value)) }}
        href="#" 
        role="button" 
        data-bs-toggle="dropdown" 
        data-bs-auto-close="false"
        aria-expanded="{{ $active }}"
    >
        @if($icon)
        <span class="me-1">{{ $icon }}</span>
        @endif 
        <span>{{ $attributes->get('title') }}</span>
    </a>
    <ul 
        class="dropdown-menu {{ $active ? 'show' : '' }}"
    >
        {{ $slot }}
    </ul>
</li> 