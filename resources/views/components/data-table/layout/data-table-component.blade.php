<div 
    x-data="dataTable()"
    x-on:reset-selects.window="resetSelectAll"
    {{ $attributes->merge([
        'class' => 'data-table',
    ])->filter(fn ($value) => is_string($value)) }}    
>
    @if(isset($filter))
    <div 
        {{ $filter->attributes->merge([
            'class' => 'd-flex flex-wrap gap-2 w-100',
        ])->filter(fn ($value) => is_string($value)) }}  
    >
        {{ $filter }}
    </div>
    @endif

    @if(isset($action))
    <div
        {{ $action->attributes->merge([
            'class' => 'd-flex my-3 gap-2 w-100',
        ])->filter(fn ($value) => is_string($value)) }}  
    >
        @if(isset($selected))
        <div
            {{ $selected->attributes->merge([
                'class' => 'flex-fill gap-2 d-flex',
            ])->filter(fn ($value) => is_string($value)) }}  
        >
            {{ $selected }}
        </div>
        @endif

        {{ $action }}
    </div>
    @endif

    <div class="table-responsive">
        <table 
            x-on:highlight.window="highlight(event.detail)"
            {{ $table->attributes->merge([
                'class' => 'table table-striped table-hover align-middle',
            ])->filter(fn ($value) => is_string($value)) }}             
        >
            <thead>
                <tr>
                    {{ $thead }}
                </tr>
            </thead>

            {{ $tbodies }}
        </table>
    </div>

    <div 
        {{ $pagination->attributes->merge([
            'class' => 'd-flex justify-content-center my-3 gap-2 w-100',
        ])->filter(fn ($value) => is_string($value)) }}      
    >
        {{ $pagination }}
    </div>
</div>