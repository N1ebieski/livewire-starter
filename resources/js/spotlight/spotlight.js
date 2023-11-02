import "../vendor/livewire-ui-spotlight/spotlight.js";

// Fix focus in bootstrap modal
document.addEventListener("focusin", function (e) {
    if (e.target.closest(".spotlight") !== null) {
        e.stopImmediatePropagation();
    }
});

const baseSpotlight = window.LivewireUISpotlight;

delete window.LivewireUISpotlight;

export default function spotlight(data) {
    return {
        ...baseSpotlight(data),

        _init() {
            const el = this;

            this.$watch("selectedCommand", function (value) {
                if (value === null) {
                    return;
                }

                el.selected = 0;

                el.$refs.input.focus();
            });

            this.$watch("isOpen", function (value) {
                if (value === false || el.selectedCommand !== null) {
                    setTimeout(() => el.reset(), 100);
                    
                    return;
                }

                const defaultCommand = el.commands.find(
                    (command) => command.default
                );

                if (!defaultCommand) {
                    return;
                }

                el.go(defaultCommand.id);
            });            
        },

        dispose() {
            const items = document.querySelectorAll('.spotlight .item');

            items.forEach((item) => item.remove());

            this.reset();
        },

        filteredItems() {
            if (this.searchEngine === "search" && this.input && this.showResultsWithoutInput) {
                return this.dependencySearch.getIndex().docs.map((item, i) => [{ item: item }, i]);
            }

            const baseFilteredItems = baseSpotlight(data).filteredItems.bind(this);

            return baseFilteredItems();
        },

        reset() {
            this.input = "";
            this.inputPlaceholder = data.placeholder;
            this.searchEngine = "commands";
            this.resolvedDependencies = {};
            this.selectedCommand = null;
            this.currentDependency = null;
            this.selectedCommand = null;
            this.requiredDependencies = [];
            this.dependencySearch.setCollection([]);
            this.$refs.input.focus();
        },
    };
}
