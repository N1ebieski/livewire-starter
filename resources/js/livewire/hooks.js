import { Livewire } from "../../../vendor/livewire/livewire/dist/livewire.esm";

Livewire.hook("commit", ({ respond }) => {
    respond(() => {
        Livewire.dispatch("livewire:commit:respond");
    });
});
