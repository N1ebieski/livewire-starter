<tr
    x-data="row({ id: @js($value) })"
    x-bind:key="`row-${id}`"
    x-bind:class="action"
    x-on:highlight.window="highlight(event)"
    {{ $attributes->class([
        'transition'
    ])->merge([
        'style' => 'height:65px'
    ])->filter(fn ($value) => is_string($value)) }}  
    wire:ignore.self
> 
    {{ $slot }}
</tr>