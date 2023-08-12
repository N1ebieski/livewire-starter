<p 
    {{ $attributes->merge([
        'class' => 'p-0 m-0 placeholder-glow',
    ])->filter(fn ($value) => is_string($value)) }}
>
    <span class="bg-primary placeholder-glow placeholder w-100"></span>
</p>  