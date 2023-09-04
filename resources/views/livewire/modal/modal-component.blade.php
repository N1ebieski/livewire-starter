<div>
    @foreach($modals as $modal)
    <div    
        x-data="modal({
            alias: @js($modal->alias),
            config: @js($modal->modal)
        })"
        x-on:hide-modal="hide($event)"
        wire:key="{{ $modal->alias }}"
        wire:ignore
    >
        <x-modal.layout.modal-component 
            :modal="$modal->modal"
            x-ref="modal"
        >
            @livewire($modal->alias, $modal->params, key($modal->alias))
        </x-modal.layout.modal-component>
    </div>
    @endforeach
</div>