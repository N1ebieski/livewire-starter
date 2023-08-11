import { Livewire } from "../livewire/livewire.js";

Livewire.on("update-title", ({ meta }) => {
    document.title = meta.title;
});
