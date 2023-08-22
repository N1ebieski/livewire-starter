<x-data-table.layout.data-table-component :isDirty="$isDirty">
    <x-slot:filter>
        <div
            class="flex-fill"
            style="min-width:300px;"
        >
            <x-forms.search-component 
                wire:model.live.debounce.750ms="form.search"
                :highlight="!is_null($form->search)"
                :labelFloating="true"
            >
                <x-slot:label>
                    {{ trans_choice('filter.filters', 1) }} "{{ trans('filter.search') }}":
                </x-slot:label> 
            </x-forms.search-component>
        </div>       
        <div>
            <x-data-table.columns-component 
                :availableColumns="$availableColumns" 
                :value="$form->columns"
            />  
        </div>
        <div>
            <x-data-table.paginate-component
                :availablePaginates="$availablePaginates"
                :value="$form->paginate"
            />
        </div>
    </x-slot:filter>
    <x-slot:action>
        <x-slot:selected>
            <x-data-table.selected-component :collection="$this->roles" />
            <x-data-table.bulk-actions.button-component
                :action="\App\View\Components\Buttons\Action::DANGER"
                :label="trans('default.delete')"
                x-on:click="bulkAction('deleteMulti')"              
            >        
                <x-slot:icon>
                    <i class="bi bi-trash3"></i>
                </x-slot:icon>
            </x-data-table.actions.button-component>                    
        </x-slot:selected>
        <x-data-table.actions.button-component
            :action="\App\View\Components\Buttons\Action::PRIMARY"
            :label="trans('default.create')"
            wire:click="create"
        >        
            <x-slot:icon>
                <i class="bi bi-plus-square"></i>
            </x-slot:icon>        
        </x-data-table.actions.button-component>
    </x-slot:action>
    <x-slot:table>
        <x-slot:thead>
            <x-data-table.label.select-all-component />
            <x-data-table.label.label-component 
                name="id"
                :value="$form->orderby"
                :columns="$form->columns"
                :hidingColumns="$hidingColumns"                        
                :sorts="$sorts"
                style="min-width:60px"                        
            >
                ID
            </x-data-table.label-component>  
            <x-data-table.label.label-component 
                name="name"
                :value="$form->orderby"
                :columns="$form->columns"
                :hidingColumns="$hidingColumns"                        
                :sorts="$sorts"
                class="w-100"                    
            >
                {{ trans('role.name.label') }}
            </x-data-table.label-component>        
            <x-data-table.label.label-component 
                name="created_at"
                :value="$form->orderby"
                :columns="$form->columns"
                :hidingColumns="$hidingColumns"
                :sorts="$sorts"
                style="min-width:100px;"
            >
                {{ trans('default.created_at') }}
            </x-data-table.label-component>            
            <x-data-table.label.label-component 
                name="updated_at"
                :value="$form->orderby"
                :columns="$form->columns"
                :hidingColumns="$hidingColumns"
                :sorts="$sorts"
                style="min-width:130px;"
            >
                {{ trans('default.updated_at') }}
            </x-data-table.label-component>
            <th></th>
            <th></th>
        </x-slot:thead>
        <x-slot:tbody>
            @foreach($this->roles as $role)       
            <x-data-table.row-component 
                :value="$role->id"
                wire:key="role-row-{{ $role->id }}"
            >
                <x-data-table.column.select-component :value="$role->id" />
                <x-data-table.column.column-component
                    name="id"
                    :columns="$form->columns"
                    :hidingColumns="$hidingColumns"
                >
                    {{ $role->id }}
                </x-data-table.column.column-component>
                <x-data-table.column.column-component
                    name="name"
                    :columns="$form->columns"
                    :hidingColumns="$hidingColumns"
                >
                    {{ $role->name }}
                </x-data-table.column.column-component>   
                <x-data-table.column.column-component
                    name="created_at"
                    :columns="$form->columns"
                    :hidingColumns="$hidingColumns"
                > 
                    {{ $role->created_at }}
                </x-data-table.column.column-component>
                <x-data-table.column.column-component
                    name="updated_at"
                    :columns="$form->columns"
                    :hidingColumns="$hidingColumns"
                >
                    {{ $role->updated_at }}
                </x-data-table.column.column-component>           
                <x-data-table.column.column-component class="text-nowrap">
                    <x-data-table.actions.button-component
                        :action="\App\View\Components\Buttons\Action::PRIMARY"
                        :label="trans('default.edit')"
                        wire:click.stop="edit('{{ $role->id }}')"
                    >
                        <x-slot:icon>
                            <i class="bi bi-pencil-square"></i>
                        </x-slot:icon>        
                    </x-data-table.actions.button-component>    
                </x-data-table.column.column-component>
                <x-data-table.column.column-component class="text-nowrap">
                    <x-data-table.actions.button-component
                        :action="\App\View\Components\Buttons\Action::DANGER"
                        :label="trans('default.delete')"
                        wire:click.stop="delete('{{ $role->id }}')"
                    >        
                        <x-slot:icon>
                            <i class="bi bi-trash3"></i>
                        </x-slot:icon>        
                    </x-data-table.actions.button-component>    
                </x-data-table.column.column-component>                
            </x-data-table.row-component>
            @endforeach
        </x-slot:tbody>
    </x-slot:table>
    <x-slot:pagination>
        <x-data-table.pagination-component :collection="$this->roles" />
    </x-slot:pagination>  
</x-data-table.layout.data-table-component>