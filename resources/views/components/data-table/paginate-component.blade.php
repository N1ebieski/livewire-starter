<div 
    {{ $attributes->merge([
        'class' => 'form-floating',
    ])->filter(fn ($value) => is_string($value)) }} 
>
    <select 
        class="form-select {{ $value !== $availablePaginates[0] ? 'highlight' : '' }}" 
        id="paginate" 
        wire:model.live="form.paginate"
    >
        @foreach($availablePaginates as $paginate)
        <option value="{{ $paginate }}">{{ $paginate }}</option>
        @endforeach                
    </select>
    <label for="paginate">
        <span 
            class="d-none"
            wire:loading 
            wire:target="form.paginate"
            wire:loading.class.remove="d-none" 
        >
            <span 
                class="spinner-border spinner-border-sm" 
                role="status" 
                aria-hidden="true"
            ></span>
            <span class="visually-hidden">{{ trans('default.loading') }}...</span>
        </span>             
    </label>    
</div>