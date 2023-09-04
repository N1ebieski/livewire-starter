<tr
    x-data="row({ id: @js($value) })"
    x-bind:key="`row-${id}`"
    x-bind:class="action"
    x-on:highlight.window="highlight(event)"
    x-on:click="toggleSelect(id)"
    {{ $attributes->class(['transition'])->filter(fn ($value) => is_string($value)) }}  
> 
    {{ $slot }}
</tr>