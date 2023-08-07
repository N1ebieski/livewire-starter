<x-data-table.layout.data-table-component>
    <x-slot:filter>
        <div
            class="flex-fill"
            style="min-width:300px;"
        >
            <x-form.search-component 
                wire:model.live.debounce.750ms="form.search"
                :highlight="!is_null($form->search)"
                :labelFloating="true"
            >
                <x-slot:label>
                    {{ trans('filter.filter') }} "{{ trans('filter.search') }}":
                </x-slot:label> 
            </x-form.search-component>
        </div>
        <div style="min-width:200px;">
            <x-form.select-component
                wire:model.live="form.status_email"
                :highlight="!is_null($form->status_email)"
                :labelFloating="true"
            >
                <x-slot:label>
                    {{ trans('filter.filter') }} "{{ trans('user.status_email.label') }}":
                </x-slot:label>

                <option value="">{{ trans('filter.default') }}</option>
                @foreach(\App\Filters\User\StatusEmail::cases() as $enum)
                <option value="{{ $enum->value }}">
                    {{ trans('user.status_email.' . $enum->value) }}
                </option>
                @endforeach
            </x-form.select-component>
        </div>
        <div>
            <x-data-table.columns-component 
                :availableColumns="$availableColumns" 
                :value="$form->columns"
            />  
        </div>      
    </x-slot:filter>
    <x-slot:table>
        <x-slot:thead>
            <x-data-table.label.select-all-component 
                :lazy="$lazy"                     
            />
            <x-data-table.label.label-component 
                name="id"
                :value="$form->orderby"
                :columns="$form->columns"
                :hidingColumns="$hidingColumns"                        
                :sorts="$sorts"
                :lazy="$lazy"
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
                :lazy="$lazy"    
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
                :lazy="$lazy"  
                style="min-width:200px"
            >
                {{ trans('user.email.label') }}
            </x-data-table.label-component> 
            <x-data-table.label.label-component 
                name="email_verified_at"
                :value="$form->orderby"
                :columns="$form->columns"
                :hidingColumns="$hidingColumns"
                :sorts="$sorts"
                :lazy="$lazy"
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
                :lazy="$lazy"
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
                :lazy="$lazy"
                style="min-width:130px;"
            >
                {{ trans('default.updated_at') }}
            </x-data-table.label-component>
        </x-slot:thead>
        <x-slot:tbody>
            @foreach($this->users as $user)                                                                  
            <x-data-table.row-component 
                :value="$user?->id"
                :lazy="$lazy"
            >
                <x-data-table.column.select-component 
                    :value="$user?->id" 
                    :lazy="$lazy"
                />
                <x-data-table.column.column-component
                    :value="$user?->id"
                    name="id"
                    :columns="$form->columns"
                    :hidingColumns="$hidingColumns"
                    :lazy="$lazy"
                />
                <x-data-table.column.column-component
                    name="name"
                    :columns="$form->columns"
                    :hidingColumns="$hidingColumns"
                    :lazy="$lazy"
                    :value="$user?->name"
                />
                <x-data-table.column.column-component
                    name="email"
                    :columns="$form->columns"
                    :hidingColumns="$hidingColumns"
                    :lazy="$lazy"
                    :value="$user?->email"
                />
                <x-data-table.column.column-component
                    name="email_verified_at"
                    :value="$user?->email_verified_at"
                    :columns="$form->columns"
                    :hidingColumns="$hidingColumns"
                    :lazy="$lazy"
                />                 
                <x-data-table.column.column-component
                    name="created_at"
                    :value="$user?->created_at"
                    :columns="$form->columns"
                    :hidingColumns="$hidingColumns"
                    :lazy="$lazy"
                /> 
                <x-data-table.column.column-component
                    :value="$user?->updated_at"
                    name="updated_at"
                    :columns="$form->columns"
                    :hidingColumns="$hidingColumns"
                    :lazy="$lazy"
                />                                                                 
            </x-data-table.row-component>
            @endforeach
        </x-slot:tbody>
    </x-slot:table>
    <x-slot:pagination>
        <x-data-table.pagination-component 
            :lazy="$lazy"
            :collection="$this->users"
        />
    </x-slot:pagination>  
</x-data-table.layout.data-table-component>