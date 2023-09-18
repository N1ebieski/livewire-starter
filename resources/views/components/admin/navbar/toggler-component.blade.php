<button 
    {{ $attributes->class([
        'navbar-toggler', 'd-block'
    ])->filter(fn ($value) => is_string($value)) }}    
    type="button" 
>
    <span class="navbar-toggler-icon"></span>
</button>