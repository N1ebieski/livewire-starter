import * as Popper from "@popperjs/core";
import * as bootstrap from "bootstrap";
import { Livewire } from "../../vendor/livewire/livewire/dist/livewire.esm";
import "./bootstrap";

import "./modal/modal";
// import "./toast/toast";

window.bootstrap = bootstrap;
window.Popper = Popper;

Livewire.start();
