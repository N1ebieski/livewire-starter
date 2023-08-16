import * as Popper from "@popperjs/core";
import * as bootstrap from "bootstrap";
import "./bootstrap";
import { Alpine, Livewire } from "./livewire/livewire.js";

import sidebar from "./admin/sidebar/sidebar";
import bulkAction from "./data-table/bulk-action";
import dataTable from "./data-table/data-table";
import row from "./data-table/row";
import "./gototop/gototop";
import "./livewire/hooks";
import "./meta/meta";
import modal from "./modal/modal";
import multiTheme from "./multi-theme/multi-theme";
import navbar from "./navbar/navbar";
import toast from "./toast/toast";
import tomSelect from "./tomselect/tomselect";

Alpine.data("modal", modal);
Alpine.data("navbar", navbar);
Alpine.data("sidebar", sidebar);
Alpine.data("dataTable", dataTable);
Alpine.data("row", row);
Alpine.data("bulkAction", bulkAction);
Alpine.data("tomSelect", tomSelect);
Alpine.data("toast", toast);
Alpine.data("multiTheme", multiTheme);

window.bootstrap = bootstrap;
window.Popper = Popper;

Livewire.start();
