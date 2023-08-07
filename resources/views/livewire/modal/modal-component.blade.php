<div>
    @foreach($modals as $modal)
    <div    
        x-data="modal({
            alias: @js($modal->alias),
            config: @js($modal->modal)
        })"
        x-on:hide-modal="hide($event.detail)"
        wire:key="{{ $modal->alias }}"
        wire:ignore
    >
        <x-modal.modal-component 
            :modal="$modal->modal"
            x-ref="modal"
        >
            @livewire($modal->alias, $modal->params, key($modal->alias))
        </x-modal.modal-component>
    </div>
    @endforeach
</div>