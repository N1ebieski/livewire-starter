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
        <div 
            class="flex-fill"        
            style="min-width:200px;"
        >
            <x-forms.select-component
                wire:model.live="form.status_email"
                :highlight="!is_null($form->status_email)"
                :labelFloating="true"
            >
                <x-slot:label>
                    {{ trans_choice('filter.filters', 1) }} "{{ trans('user.status_email.label') }}":
                </x-slot:label>

                <option value="">{{ trans('filter.default') }}</option>
                @foreach(\App\ValueObjects\User\StatusEmail::cases() as $enum)
                <option value="{{ $enum->value }}">
                    {{ trans('user.status_email.' . $enum->value) }}
                </option>
                @endforeach
            </x-forms.select-component>
        </div>
        <div class="flex-fill">
            <x-forms.select-component
                wire:model.live="form.role"
                :highlight="!is_null($form->role)"
                :labelFloating="true"
            >
                <x-slot:label>
                    {{ trans_choice('filter.filters', 1) }} "{{ trans('user.roles.label') }}":
                </x-slot:label>

                <option value="">{{ trans('filter.default') }}</option>
                @foreach($this->roles as $role)
                <option value="{{ $role->id }}">
                    {{ $role->name->value }}
                </option>
                @endforeach
            </x-forms.select-component>
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
            <x-data-table.selected-component :collection="$this->users" />
            @role(\App\ValueObjects\Role\DefaultName::SUPER_ADMIN->value)
            <x-data-table.bulk-actions.button-component
                :action="\App\View\Components\Buttons\Action::DANGER"
                :label="trans('default.delete')"
                x-on:click="bulkAction('deleteMulti')"              
            >        
                <x-slot:icon>
                    <i class="bi bi-trash3"></i>
                </x-slot:icon>
            </x-data-table.actions.button-component>  
            @endrole
        </x-slot:selected>
        @can('create', \App\Models\User\User::class)
        <x-data-table.actions.button-component
            :action="\App\View\Components\Buttons\Action::PRIMARY"
            :label="trans('default.create')"
            wire:click="create"
        >        
            <x-slot:icon>
                <i class="bi bi-plus-square"></i>
            </x-slot:icon>        
        </x-data-table.actions.button-component>
        @endcan
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
                {{ trans('user.name.label') }}
            </x-data-table.label-component> 
            <x-data-table.label.label-component 
                name="email"
                :value="$form->orderby"
                :columns="$form->columns"
                :hidingColumns="$hidingColumns"                        
                :sorts="$sorts"
                style="min-width:200px"
            >
                {{ trans('user.email.label') }}
            </x-data-table.label-component>
            <x-data-table.label.label-component 
                name="roles"
                :value="$form->orderby"
                :columns="$form->columns"
                :hidingColumns="$hidingColumns"                        
                :sorts="$sorts"
                style="min-width:100px"
            >
                {{ trans('user.roles.label') }}
            </x-data-table.label-component>
            <x-data-table.label.label-component 
                name="email_verified_at"
                :value="$form->orderby"
                :columns="$form->columns"
                :hidingColumns="$hidingColumns"
                :sorts="$sorts"
                style="min-width:150px;"
            >
                {{ trans('user.email_verified_at') }}
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
            <x-data-table.label.label-component 
                name="status_email_verified_at"
                :sorts="$sorts"
            >
                {{ trans('user.status_email.label') }}
            </x-data-table.label-component>
            <th></th>
            <th></th>
        </x-slot:thead>
        <x-slot:tbody>
            @foreach($this->users as $user)       
            <x-data-table.row-component 
                :value="$user->id"
                wire:key="user-row-{{ $user->id }}"
            >
                <x-data-table.column.select-component :value="$user->id" />
                <x-data-table.column.column-component
                    name="id"
                    :columns="$form->columns"
                    :hidingColumns="$hidingColumns"
                >
                    {{ $user->id }}
                </x-data-table.column.column-component>
                <x-data-table.column.column-component
                    name="name"
                    :columns="$form->columns"
                    :hidingColumns="$hidingColumns"
                >
                    {{ $user->name }}
                </x-data-table.column.column-component>
                <x-data-table.column.column-component
                    name="email"
                    :columns="$form->columns"
                    :hidingColumns="$hidingColumns"
                >
                    {{ $user->email }}
                </x-data-table.column.column-component>
                <x-data-table.column.column-component
                    name="roles"
                    :columns="$form->columns"
                    :hidingColumns="$hidingColumns"
                >
                    {{ $user->roles->pluck('name')->implode(', ') }}
                </x-data-table.column.column-component>    
                <x-data-table.column.column-component
                    name="email_verified_at"
                    :columns="$form->columns"
                    :hidingColumns="$hidingColumns"
                >      
                    {{ $user->email_verified_at }}           
                </x-data-table.column.column-component>
                <x-data-table.column.column-component
                    name="created_at"
                    :columns="$form->columns"
                    :hidingColumns="$hidingColumns"
                > 
                    {{ $user->created_at }}
                </x-data-table.column.column-component>
                <x-data-table.column.column-component
                    name="updated_at"
                    :columns="$form->columns"
                    :hidingColumns="$hidingColumns"
                >
                    {{ $user->updated_at }}
                </x-data-table.column.column-component>
                <x-data-table.column.column-component>
                    @can('toggleStatusEmail', $user) 
                    <x-data-table.actions.toggle-component
                        wire:click.stop="toggleStatusEmail('{{ $user->id }}')"
                        :checked="!is_null($user->email_verified_at)"
                    />
                    @endcan
                </x-data-table.column.column-component>           
                <x-data-table.column.column-component class="text-nowrap">
                    @can('edit', $user) 
                    <x-data-table.actions.button-component
                        :action="\App\View\Components\Buttons\Action::PRIMARY"
                        :label="trans('default.edit')"
                        wire:click.stop="edit('{{ $user->id }}')"
                    >        
                        <x-slot:icon>
                            <i class="bi bi-pencil-square"></i>
                        </x-slot:icon>        
                    </x-data-table.actions.button-component>  
                    @endcan  
                </x-data-table.column.column-component>
                <x-data-table.column.column-component class="text-nowrap">
                    @can('delete', $user)
                    <x-data-table.actions.button-component
                        :action="\App\View\Components\Buttons\Action::DANGER"
                        :label="trans('default.delete')"
                        wire:click.stop="delete('{{ $user->id }}')"
                    >        
                        <x-slot:icon>
                            <i class="bi bi-trash3"></i>
                        </x-slot:icon>        
                    </x-data-table.actions.button-component> 
                    @endcan   
                </x-data-table.column.column-component>                
            </x-data-table.row-component>
            @endforeach
        </x-slot:tbody>
    </x-slot:table>
    <x-slot:pagination>
        <x-data-table.pagination-component :collection="$this->users" />
    </x-slot:pagination>  
</x-data-table.layout.data-table-component>