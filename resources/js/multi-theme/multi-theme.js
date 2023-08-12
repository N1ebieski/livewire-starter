export default function modal(data) {
    return {
        theme: data.theme,

        toggle(theme) {
            this.theme = theme;

            this.createCookie();

            window.location.reload();
        },

        createCookie() {
            document.cookie = `theme_toggle=${this.theme}; path=/; expires=Fri, 31 Dec 9999 23:59:59 GMT`;
        },
    };
}
