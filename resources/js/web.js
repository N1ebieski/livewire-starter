import * as Popper from "@popperjs/core";
import * as bootstrap from "bootstrap";
import {
    Alpine,
    Livewire,
} from "../../vendor/livewire/livewire/dist/livewire.esm";
import "./bootstrap";

import "./livewire/hooks";
import modal from "./modal/modal";
import multiTheme from "./multi-theme/multi-theme";
import navbar from "./navbar/navbar";
import scrollToTop from "./scroll-to-top/scroll-to-top";
import sidebar from "./sidebar/sidebar";
import spotlight from "./spotlight/spotlight";
import toast from "./toast/toast";

Alpine.data("modal", modal);
Alpine.data("multiTheme", multiTheme);
Alpine.data("navbar", navbar);
Alpine.data("sidebar", sidebar);
Alpine.data("spotlight", spotlight);
Alpine.data("toast", toast);
Alpine.data("scrollToTop", scrollToTop);

window.bootstrap = bootstrap;
window.Popper = Popper;

Livewire.start();
