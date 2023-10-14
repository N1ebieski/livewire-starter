import { Livewire } from "../../../vendor/livewire/livewire/dist/livewire.esm";
import { Commit } from "./commit";

Livewire.hook("commit.prepare", () => {
    Commit.responded = false;
});

Livewire.hook("commit", ({ respond }) => {
    respond(() => {
        Commit.responded = true;

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
