<div class="modal-content">
    <div class="modal-header d-block">
        <div class="d-flex justify-content-between w-100">
            <h1 
                {{ $title->attributes->class([
                    'modal-title', 'fs-5'
                ])->filter(fn ($attr) => is_string($attr)) }}
            >
                {{ $title }}
            </h1>
            <button 
                type="button" 
                class="btn-close ms-1 align-self-center" 
                data-bs-dismiss="modal" 
                aria-label="{{ trans('default.close') }}"
            ></button>
        </div>
        @if(isset($header))
        {{ $header }}
        @endif
    </div>
    @if(isset($body))
    <div 
        {{ $body->attributes->class([
            'modal-body'
        ])->filter(fn ($attr) => is_string($attr)) }}
    >
        {{ $body }}
    </div>
    @endif
    @if(isset($footer))
    <div 
        {{ $footer->attributes->class([
            'modal-footer'
        ])->filter(fn ($attr) => is_string($attr)) }}
    >
        {{ $footer }}
    </div>
    @endif
</div>