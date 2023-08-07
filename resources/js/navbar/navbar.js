export default function navbar(data) {
    return {
        autohide: data.autohide,
        show: true,
        currentScrollTop: 0,
        previousScrollTop: 0,

        init() {
            if (!this.isAutohide()) {
                return;
            }

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
                .classList.contains("modal_open");
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
