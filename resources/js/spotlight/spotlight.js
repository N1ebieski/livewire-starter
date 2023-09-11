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
