<div
    x-data="{ outside: false }"
    x-on:click.outside="
        if (outside) {
            $wire.$dispatchSelf('refresh')
        }
        outside = false
    "   
    {{ $attributes->class(['dropdown'])->filter(fn ($value) => is_string($value)) }}
>
    <button 
        class="btn dropdown-toggle border columns"
        type="button" 
        data-bs-toggle="dropdown" 
        data-bs-auto-close="outside" 
        aria-expanded="false"
    >
        <span wire:loading.remove wire:target="form.columns">
            <i class="bi bi-columns"></i>
        </span>
        <span 
            class="d-none"
            wire:loading 
            wire:target="form.columns"
            wire:loading.class.remove="d-none" 
        >
            <span 
                class="spinner-border spinner-border-sm" 
                role="status" 
                aria-hidden="true"
            ></span>
            <span class="visually-hidden">{{ trans('default.loading') }}...</span>
        </span>
        <span class="d-none d-md-inline">{{ trans('data-table.columns') }}</span>
    </button>

    <ul 
        class="dropdown-menu" 
        style="min-width: 200px;"
    >
        @foreach ($availableColumns as $column => $label)
        <li>
            <div class="dropdown-item">
                <div 
                    x-data="{ 
                        show: @js(in_array($column, $value)),
                        id: $id('column-{{ $column }}')
                    }"
                    x-key="$column"
                    class="form-check form-switch"
                >
                    <input 
                        class="form-check-input" 
                        type="checkbox" 
                        role="switch" 
                        :id="id"
                        wire:model="form.columns"
                        x-on:click="
                            outside = true
                            show = !show
                        "
                        value="{{ $column }}"
                        {{ in_array($column, $value) ? 'checked' : '' }}
                    >
                    <label class="form-check-label" :for="id">
                        <span x-cloak x-show="show">{{ trans('data-table.show') }}</span>
                        <span x-cloak x-show="!show">{{ trans('data-table.hide') }}</span>
                        <span>"{{ $label ?? $column }}"</span>
                    </label>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>