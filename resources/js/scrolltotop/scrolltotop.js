export default function scrollToTop() {
    return {
        show: false,

        init() {
            this.toggle();

            window.addEventListener("scroll", () => {
                this.toggle();
            });
        },

        scroll() {
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        },

        toggle() {
            const scrollTop = window.scrollY;

            if (scrollTop > 100) {
                this.show = true;
            } else {
                this.show = false;
            }
        },
    };
}
