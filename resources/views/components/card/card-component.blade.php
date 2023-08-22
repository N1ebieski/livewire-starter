<div 
    {{ $attributes->class([
        'card',
        "text-bg-{$action?->value}" => !is_null($action)
    ])->filter(fn ($value) => is_string($value)) }}
>
    @if (isset($header))
    <div 
        {{ $header->attributes->class([
            'card-header'
        ])->filter(fn ($value) => is_string($value)) }}
    >
        {{ $header }}
    </div>
    @endif

    @if(isset($body))
    <div
        {{ $body->attributes->class([
            'card-body'
        ])->filter(fn ($value) => is_string($value)) }}    
    >
        {{ $body }}
    </div>
    @endif

    @if(isset($footer))
    <div 
        {{ $footer->attributes->class([
            'card-footer'
        ])->filter(fn ($value) => is_string($value)) }}     
    >
        {{ $footer }}
    </div>
    @endif
</div>