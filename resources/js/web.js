import * as Popper from "@popperjs/core";
import * as bootstrap from "bootstrap";
import {
    Alpine,
    Livewire,
} from "../../vendor/livewire/livewire/dist/livewire.esm";
import "./bootstrap";

import "./modal/modal";
import multiTheme from "./multi-theme/multi-theme";
import navbar from "./navbar/navbar";
import spotlight from "./spotlight/spotlight";
// import "./toast/toast";

Alpine.data("multiTheme", multiTheme);
Alpine.data("navbar", navbar);
Alpine.data("spotlight", spotlight);

window.bootstrap = bootstrap;
window.Popper = Popper;

Livewire.start();
