<li 
    class="nav-item dropdown"
>
    <a 
        {{ $attributes->class([
            'nav-link', 'dropdown-toggle'
        ])->filter(fn ($value) => is_string($value)) }}
        href="#" 
        role="button" 
        data-bs-toggle="dropdown" 
        data-bs-auto-close="true"
    >
        @if(isset($icon))
        <span>{{ $icon }}</span>
        @endif 
        @if(isset($title))
        <span>{{ $title }}</span>
        @endif
    </a>
    <ul 
        class="dropdown-menu dropdown-menu-end"
    >
        {{ $slot }}
    </ul>
</li> 