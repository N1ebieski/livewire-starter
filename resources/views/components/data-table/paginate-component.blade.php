<div 
    {{ $attributes->merge([
        'class' => 'form-floating',
    ])->filter(fn ($value) => is_string($value)) }} 
>
    <select 
        class="form-select {{ $value !== $availablePaginates[0] ? 'active' : '' }}" 
        id="paginate" 
        wire:model="paginate"
    >
        @foreach($availablePaginates as $paginate)
        <option value="{{ $paginate }}">{{ $paginate }}</option>
        @endforeach                
    </select>
    <label for="paginate">
        <span wire:loading wire:target="paginate">
            <span 
                class="spinner-border spinner-border-sm" 
                role="status" 
                aria-hidden="true"
            ></span>
            <span class="visually-hidden">{{ trans('default.loading') }}...</span>
        </span>             
    </label>    
</div>