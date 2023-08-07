import * as Popper from "@popperjs/core";
import * as bootstrap from "bootstrap";
import "./bootstrap";
import { Alpine, Livewire } from "./livewire/livewire.js";

import sidebar from "./admin/sidebar/sidebar";
import bulkAction from "./data-table/bulk-action";
import dataTable from "./data-table/data-table";
import "./gototop/gototop";
import modal from "./modal/modal";
import navbar from "./navbar/navbar";

Alpine.data("modal", modal);
Alpine.data("navbar", navbar);
Alpine.data("sidebar", sidebar);
Alpine.data("dataTable", dataTable);
Alpine.data("bulkAction", bulkAction);

window.bootstrap = bootstrap;
window.Popper = Popper;

Livewire.start();
