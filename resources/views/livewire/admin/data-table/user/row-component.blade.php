<x-data-table.row-component :value="$user?->id">
    <x-data-table.column.select-component :value="$user?->id" />
    <x-data-table.column.column-component
        name="id"
        :columns="$columns"
        :hidingColumns="$hidingColumns"
    >
        {{ $user?->id }}
    </x-data-table.column.column-component>
    <x-data-table.column.column-component
        name="name"
        :columns="$columns"
        :hidingColumns="$hidingColumns"
    >
        {{ $user?->name }}
    </x-data-table.column.column-component>
    <x-data-table.column.column-component
        name="email"
        :columns="$columns"
        :hidingColumns="$hidingColumns"
    >
        {{ $user?->email }}
    </x-data-table.column.column-component>
    <x-data-table.column.column-component
        name="email_verified_at"
        :columns="$columns"
        :hidingColumns="$hidingColumns"
    >      
        {{ $user?->email_verified_at }}           
    </x-data-table.column.column-component>
    <x-data-table.column.column-component
        name="created_at"
        :columns="$columns"
        :hidingColumns="$hidingColumns"
    > 
        {{ $user?->created_at }}
    </x-data-table.column.column-component>
    <x-data-table.column.column-component
        name="updated_at"
        :columns="$columns"
        :hidingColumns="$hidingColumns"
    >
        {{ $user?->updated_at }}
    </x-data-table.column.column-component>
    <x-data-table.column.column-component class="text-nowrap">
        <x-data-table.actions.button-component
            :action="\App\View\Components\Action::PRIMARY"
            :label="trans('default.edit')"
            wire:click.stop="edit"
        >        
            <x-slot:icon>
                <i class="bi bi-pencil-square"></i>
            </x-slot:icon>        
        </x-data-table.actions.button-component>    
    </x-data-table.column.column-component>
</x-data-table.row-component>