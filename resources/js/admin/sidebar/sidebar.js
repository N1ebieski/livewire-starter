import { Offcanvas } from "bootstrap";

export default function sidebar(data) {
    return {
        show: data.show,
        scroll: true,
        backdrop: false,
        display: false,
        offcanvas: null,

        init() {
            if (this.isSizeDownLg()) {
                this.setDownLg();
            }

            this.offcanvas = new Offcanvas(`#${this.$refs.sidebar.id}`, {
                scroll: this.scroll,
                backdrop: this.backdrop,
            });

            this.offcanvas._isShown = this.show;

            this.$refs.sidebar.addEventListener("hide.bs.offcanvas", () => {
                this.show = false;

                if (!this.isSizeDownLg()) {
                    this.createCookie();
                }
            });

            this.$refs.sidebar.addEventListener("show.bs.offcanvas", () => {
                this.show = true;

                if (!this.isSizeDownLg()) {
                    this.createCookie();
                }
            });
        },

        destroy() {
            if (this.isSizeDownLg()) {
                const sidebarWrapper =
                    document.querySelector(".sidebar-wrapper");

                const sidebar = document.querySelector(".sidebar");

                const backdrop = document.querySelector(".offcanvas-backdrop");

                sidebarWrapper.classList.remove("show");

                sidebar.classList.remove("show");

                if (backdrop) {
                    backdrop.remove();
                }
            }

            this.offcanvas.dispose();
        },

        isSizeDownLg() {
            return window.innerWidth < 1200;
        },

        getShowAsString() {
            return this.show === true ? "true" : "false";
        },

        createCookie() {
            document.cookie = `admin_sidebar_toggle=${this.getShowAsString()}; path=/; expires=Fri, 31 Dec 9999 23:59:59 GMT`;
        },

        removeCookie() {
            document.cookie = "admin_sidebar_toggle=; Max-Age=0; path=/";
        },

        setDownLg() {
            this.show = false;

            this.scroll = false;
            this.backdrop = true;

            this.display = true;

            this.removeCookie();
        },
    };
}
