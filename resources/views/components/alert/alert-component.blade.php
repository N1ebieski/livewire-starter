<div 
    {{ $attributes->class([
        'alert',
        "alert-{$action->value}",
        'alert-dismissible' => $close,
        'fade' => $close,
        'show' => $close
    ])->filter(fn ($value) => is_string($value)) }}
    role="alert"
>
    {{ $slot }}
    @if($close)
    <button 
        type="button" 
        class="btn-close" 
        data-bs-dismiss="alert" 
        aria-label="{{ trans('default.close') }}"
    ></button>
    @endif
</div>