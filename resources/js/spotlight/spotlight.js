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

                el.$refs.input.focus();
            });

            this.$watch("isOpen", function (value) {
                if (value === false || el.selectedCommand !== null) {
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

        destroy() {
            const items = document.querySelectorAll('.spotlight .item');

            items.forEach((item) => item.remove());

            this.reset();
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
