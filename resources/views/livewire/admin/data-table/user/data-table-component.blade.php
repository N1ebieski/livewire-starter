<x-data-table.layout.data-table-component>
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
                    {{ trans('filter.filter') }} "{{ trans('filter.search') }}":
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
                    {{ trans('filter.filter') }} "{{ trans('user.status_email.label') }}":
                </x-slot:label>

                <option value="">{{ trans('filter.default') }}</option>
                @foreach(\App\Filters\User\StatusEmail::cases() as $enum)
                <option value="{{ $enum->value }}">
                    {{ trans('user.status_email.' . $enum->value) }}
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
        </x-slot:selected>
        @if($isDirty)
        <x-data-table.actions.button-component
            :action="\App\View\Components\Action::SECONDARY"
            :label="trans('default.clear')"
            wire:click="clear"
        >
            <x-slot:icon>
                <i class="bi bi-x-square"></i>
            </x-slot:icon>
        </x-data-table.actions.button-component>
        @endif
        <x-data-table.actions.button-component
            :action="\App\View\Components\Action::PRIMARY"
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
            <th></th>
        </x-slot:thead>
        <x-slot:tbodies>
            @foreach($this->users as $index => $user)        
            <x-data-table.row-component :value="$user?->id">      
                <livewire:admin.data-table.user.row-component
                    :user="$user"
                    :hidingColumns="$hidingColumns"
                    :columns="$form->columns"
                    wire:key="user-row-{{ $index }}"
                />
            </x-data-table.row-component>
            @endforeach
        </x-slot:tbodies>
    </x-slot:table>
    <x-slot:pagination>
        <x-data-table.pagination-component :collection="$this->users" />
    </x-slot:pagination>  
</x-data-table.layout.data-table-component>