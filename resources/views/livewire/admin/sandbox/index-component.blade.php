<x-admin.layouts.app.panel-component>
    <x-slot:breadcrumb>
        <x-breadcrumb.item-component :active="true">
            Sandbox
        </x-breadcrumb.item-component>
    </x-slot:breadcrumb>

    <form wire:submit.prevent="submit">
        <div class="mb-3">
            <x-forms.autocomplete.autocomplete-component
                wire:model="autocomplete"
                label="Autocomplete form z label floating, closure od query oraz selection"
                labelFloating="true"
                :autocomplete="new \App\View\Components\Forms\Autocomplete\Autocomplete(
                    data: new \App\View\Components\Forms\Autocomplete\Data(
                        src: [
                            'pomorskie',
                            'kujawsko-pomorskie',
                            'mazowieckie',
                            'śląskie',
                            'łódzkie',
                            'podlaskie',
                            'zachodnio-pomorskie',
                            'warmińsko-mazurskie',
                            'wielkopolskie'
                        ]
                    ),
                    query: <<<'JS'
                        const matches = input.match(/(\S+)\s*$/);

                        return matches ? matches[1] : '';
                    JS,
                    events: new \App\View\Components\Forms\Autocomplete\Events(
                        input: new \App\View\Components\Forms\Autocomplete\Input(
                            selection: <<<'JS'
                                const query = event.detail.query;
                                const selection = event.detail.selection.value;

                                this.autocomplete.input.value = this.autocomplete.input.value.replace(
                                    new RegExp(`${query}\\s*?$`),
                                    selection
                                );
                            JS
                        )
                    )
                )"
            />
        </div>
        <div class="mb-3">
            <x-forms.tinymce.tinymce-component
                wire:model="tinymce"
                label="Tinymce"
            />
        </div>
        <div class="mb-3">
            <x-forms.datetime.datetime-component
                wire:model="datetime"
                label="Datetime"
                :labelFloating="true"
            />
        </div>
        <button type="submit" class="btn btn-primary">
            Submit
        </button>
    </form>
</x-admin.layouts.app.panel-component>
