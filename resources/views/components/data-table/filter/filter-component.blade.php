@if(in_array($name, $filters))
<div
    {{ $attributes->filter(fn ($value) => is_string($value)) }}
>
    {{ $slot }}
</div>
@endif