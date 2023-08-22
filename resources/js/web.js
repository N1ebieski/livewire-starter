import * as Popper from "@popperjs/core";
import * as bootstrap from "bootstrap";
import "./bootstrap";
import { Livewire } from "./livewire/livewire.js";

import "./modal/modal";
// import "./toast/toast";

window.bootstrap = bootstrap;
window.Popper = Popper;

Livewire.start();
