import { Livewire } from "../livewire/livewire.js";

Livewire.on("update-meta", ({ meta }) => {
    document.title = meta.title;
});
