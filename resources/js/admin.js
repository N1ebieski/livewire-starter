import * as Popper from "@popperjs/core";
import * as bootstrap from "bootstrap";
import {
    Alpine,
    Livewire,
} from "../../vendor/livewire/livewire/dist/livewire.esm";
import "./bootstrap";

import autoComplete from "./autocomplete/autocomplete";
import bulkAction from "./data-table/bulk-action";
import dataTable from "./data-table/data-table";
import row from "./data-table/row";
import "./go-to-top/go-to-top";
import "./livewire/hooks";
import "./meta/meta";
import modal from "./modal/modal";
import multiTheme from "./multi-theme/multi-theme";
import navbar from "./navbar/navbar";
import scrollToTop from "./scroll-to-top/scroll-to-top";
import sidebar from "./sidebar/sidebar";
import spotlight from "./spotlight/spotlight";
import tinyMCE from "./tinymce/tinymce";
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
Alpine.data("autoComplete", autoComplete);
Alpine.data("scrollToTop", scrollToTop);
Alpine.data("tinyMCE", tinyMCE);
Alpine.data("spotlight", spotlight);

window.bootstrap = bootstrap;
window.Popper = Popper;

Livewire.start();
