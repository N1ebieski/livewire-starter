import { Collapse, Offcanvas } from "bootstrap";

export default function navbar(data) {
    return {
        autohide: data.autohide,
        show: true,
        currentScrollTop: 0,
        previousScrollTop: 0,
        bootstrapCollapse: null,

        init() {
            if (!this.isAutohide()) {
                return;
            }

            this.bootstrapCollapse = new Collapse(this.$refs.collapse, {
                toggle: false,
            });

            this.previousScrollTop = window.scrollY;

            addEventListener("scroll", () => {
                this.toggle();
            });
        },

        isAutohide() {
            return this.autohide === true;
        },

        isRealScroll() {
            return this.previousScrollTop !== this.currentScrollTop;
        },

        isModalOpen() {
            return document
                .querySelector("body")
                .classList.contains("modal-open");
        },

        isCollapseOpen() {
            const body = document.querySelector("body");

            return body.classList.contains("navbar-collapse-open");
        },

        hideCollapse() {
            if (!this.isCollapseOpen()) {
                return;
            }

            this.bootstrapCollapse.hide();

            const body = document.querySelector("body");

            body.classList.remove("navbar-collapse-open");
            body.style.overflow = "auto";

            const backdrop = document.querySelector(
                ".navbar-collapse-backdrop"
            );

            backdrop.classList.remove("show");

            setTimeout(() => backdrop.remove(), 500);
        },

        showCollapse() {
            if (this.isCollapseOpen()) {
                return;
            }

            this.bootstrapCollapse.show();

            const body = document.querySelector("body");

            body.classList.add("navbar-collapse-open");
            body.style.overflow = "hidden";

            const backdrop = document.createElement("div");

            backdrop.classList.add("navbar-collapse-backdrop", "fade");

            body.appendChild(backdrop);

            setTimeout(() => backdrop.classList.add("show"), 50);
        },

        toggleCollapse() {
            this.bootstrapCollapse.toggle();

            const body = document.querySelector("body");

            if (body.classList.contains("navbar-collapse-open")) {
                this.hideCollapse();
            } else {
                this.showCollapse();
            }
        },

        toggleSidebar(selector = "#sidebar") {
            const offcanvas = Offcanvas.getInstance(selector);

            offcanvas.toggle();
        },

        toggleSpotlight() {
            this.$dispatch("toggle-spotlight");
        },

        toggle() {
            if (this.isModalOpen()) {
                return;
            }

            const navbar = document.querySelector(".navbar");
            const a = window.scrollY;
            const b = navbar.offsetHeight;

            this.currentScrollTop = a;

            if (!this.isRealScroll()) {
                return;
            }

            if (
                this.previousScrollTop < this.currentScrollTop &&
                this.previousScrollTop > b
            ) {
                this.show = false;
            } else {
                this.show = true;
            }

            this.previousScrollTop = this.currentScrollTop;
        },
    };
}
