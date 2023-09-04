import { Livewire } from "../../../vendor/livewire/livewire/dist/livewire.esm";

Livewire.on("update-meta", ({ meta }) => {
    document.title = meta.title;
});
