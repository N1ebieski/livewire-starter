import { Livewire } from "../../../vendor/livewire/livewire/dist/livewire.esm";

Livewire.on("gototop", () => {
    window.scrollTo({
        top: 0,
        behaviour: "smooth",
    });
});
