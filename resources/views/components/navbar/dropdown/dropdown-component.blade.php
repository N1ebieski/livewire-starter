<div class="dropdown">
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
        <span class="me-1">{{ $icon }}</span>
        @endif 
        @if(isset($title))
        <span {{ $title->attributes->filter(fn ($value) => is_string($value)) }}>
            {{ $title }}
        </span>
        @endif
    </a>
    <ul 
        class="dropdown-menu dropdown-menu-end"
    >
        {{ $slot }}
    </ul>
</div> 