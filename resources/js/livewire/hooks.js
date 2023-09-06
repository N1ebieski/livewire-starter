import { Livewire } from "../../../vendor/livewire/livewire/dist/livewire.esm";

Livewire.hook("commit", ({ respond }) => {
    respond(() => {
        Livewire.dispatch("livewire:commit:respond");
    });
});

const head = document.getElementsByTagName("head")[0];

head.addEventListener(
    "load",
    function (event) {
        if (event.target.hasAttribute("data-load")) {
            window.dispatchEvent(
                new CustomEvent(
                    event.target.getAttribute("data-load") + ":load"
                )
            );
        }
    },
    true
);
