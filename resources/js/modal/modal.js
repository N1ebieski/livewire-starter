import { Modal } from "bootstrap";

export default function modal(data) {
    return {
        ...data,
        modal: null,

        init() {
            this.modal = Modal.getOrCreateInstance(this.$refs.modal);

            this.$refs.modal.addEventListener("hidden.bs.modal", () => {
                this.$dispatch("delete-modal", { alias: data.alias });
            });

            if (data.config.static) {
                this.modal._config.backdrop = data.config.static
                    ? "static"
                    : true;
                this.modal._config.keyboard = !data.config.static;
            }

            this.modal.show();
        },

        hide(event) {
            if (event.detail.alias !== data.alias) {
                return;
            }

            this.modal.hide();
        },
    };
}
