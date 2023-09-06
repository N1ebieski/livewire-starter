<x-admin.layouts.app.slot-component>
    <x-forms.autocomplete.autocomplete-component
        name="autocomplete"
        id="autocomplete"
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
    <x-forms.tinymce.tinymce-component
        name="tinymce"
        id="tinymce"
        label="Tinymce"
    />
</x-admin.layouts.app.slot-component>
