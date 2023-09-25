import { Toast as BootstrapToast } from "bootstrap";
import { Alpine } from "../../../vendor/livewire/livewire/dist/livewire.esm";
import { Enum } from "../support/enum/enum";

class Action extends Enum {
    static SUCCESS = new Action("success");
    static WARNING = new Action("warning");
    static ALERT = new Action("alert");

    getClass() {
        const classes = {
            success: ["alert", "alert-success"],
            warning: ["alert", "alert-warning"],
            alert: ["alert", "alert-danger"],
        };

        return classes[this.value];
    }

    getRole() {
        const roles = {
            success: "status",
            warning: "status",
            alert: "alert",
        };

        return roles[this.value];
    }

    getAriaLive() {
        const ariaLive = {
            success: "polite",
            warning: "polite",
            alert: "assertive",
        };

        return ariaLive[this.value];
    }
}

class Toast {
    constructor({
        body,
        header = null,
        action = Action.SUCCESS,
        animation = "true",
        autohide = "true",
        delay = 5000,
    }) {
        this.body = body;
        this.header = header;
        this.action = action;
        this.animation = animation;
        this.autohide = autohide;
        this.delay = delay;
    }
}

export default function toast() {
    return {
        bootstrapToast: null,

        init() {
            Alpine.store("toasts", {
                collection: [],

                set(config) {
                    this.collection.push(
                        new Toast({
                            ...config,
                            ...(config.action && {
                                action: new Action(config.action),
                            }),
                        })
                    );
                },

                remove(index) {
                    delete this.collection[index];
                },
            });
        },

        initToast(index) {
            const el = document.querySelector(`#toast-${index}`);

            this.bootstrapToast = new BootstrapToast(el);

            el.addEventListener("hidden.bs.toast", () => {
                this.$store.toasts.remove(index);
            });

            this.bootstrapToast.show();
        },

        createToast(event) {
            this.$store.toasts.set(event);
        },
    };
}
