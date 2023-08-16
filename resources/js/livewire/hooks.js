import { Livewire } from "../livewire/livewire.js";

Livewire.hook("commit", ({ respond }) => {
    respond(() => {
        Livewire.dispatch("livewire:commit:respond");
    });
});
