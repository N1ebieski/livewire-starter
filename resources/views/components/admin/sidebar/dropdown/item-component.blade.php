<li>
    <a 
        {{ $attributes->class([
            'dropdown-item', 'active' => $active
        ])->filter(fn ($value) => is_string($value)) }}
        @if($active)
        aria-current="page"
        @endif
        x-on:click="navigate()"
    >
        {{ $attributes->get('title') }}
    </a>
</li>