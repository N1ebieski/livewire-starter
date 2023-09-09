import { Enum } from "../utils/enum/enum";

class Action extends Enum {
    static SUCCESS = new Action("success");
    static WARNING = new Action("warning");
    static PRIMARY = new Action("primary");

    getClass() {
        const classes = {
            success: ["table-success"],
            warning: ["table-warning"],
            primary: ["table-primary"],
        };

        return classes[this.value];
    }
}

export default function row(data) {
    return {
        ...data,
        action: [],

        highlight(event) {
            if (event.detail.alias !== this.alias) {
                return;
            }

            if (!event.detail.ids.includes(data.id)) {
                return;
            }

            const action = new Action(event.detail.action);

            this.action = action.getClass();

            const el = this;

            setTimeout(function () {
                el.action = [];
            }, 5000);
        },
    };
}
