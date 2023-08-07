import { Livewire } from "../livewire/livewire.js";

Livewire.on("gototop", () => {
    window.scrollTo({
        top: 0,
        behaviour: "smooth",
    });
});
