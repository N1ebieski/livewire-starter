<div 
    x-data="dataTable()"
    x-on:reset-selects.window="resetSelectAll"
    {{ $attributes->class(['data-table'])->filter(fn ($value) => is_string($value)) }}    
>
    @if(isset($filter))
    <x-data-table.filter-component :isDirty="$isDirty">
        <div
            {{ $filter->attributes->class([
                'd-flex', 'flex-wrap', 'gap-2', 'w-100'
            ])->filter(fn ($value) => is_string($value)) }}  
        >
            {{ $filter }}
        </div>
    </x-data-table.filter-component>
    @endif

    @if(isset($action))
    <div
        {{ $action->attributes->class([
            'd-flex', 'my-3', 'gap-2', 'w-100'
        ])->filter(fn ($value) => is_string($value)) }}  
    >
        @if(isset($selected))
        <div
            {{ $selected->attributes->class([
                'flex-fill', 'gap-2', 'd-flex'
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
            {{ $table->attributes->class([
                'table', 'table-striped', 'table-hover', 'align-middle'
            ])->filter(fn ($value) => is_string($value)) }}             
        >
            <thead>
                <tr>
                    {{ $thead }}
                </tr>
            </thead>

            <tbody>
                {{ $tbody }}
            </tbody>
        </table>
    </div>

    <div 
        {{ $pagination->attributes->class([
            'd-flex', 'justify-content-center', 'my-3', 'gap-2', 'w-100'
        ])->filter(fn ($value) => is_string($value)) }}      
    >
        {{ $pagination }}
    </div>
</div>