import { Enum } from "../utils/enum/enum";

class Action extends Enum {
    static SUCCESS = new Action("success");
    static WARNING = new Action("warning");
    static ALERT = new Action("alert");

    getClass() {
        const classes = {
            active: ["table-success"],
            inactive: ["table-warning"],
            confirm: ["table-primary"],
        };

        return classes[this.value];
    }
}

export default function dataTable() {
    return {
        selects: [],
        selectAll: false,

        init() {
            let size;

            if (window.innerWidth < 768) {
                this.showFilters = false;
                size = "sm";
            } else if (window.innerWidth < 992) {
                this.showFilters = false;
                size = "md";
            } else if (window.innerWidth < 1200) {
                size = "lg";
            }

            if (window.innerWidth >= 1200) {
                return;
            }

            this.$wire.hideColumns(size);
        },

        toggleSelectAll() {
            this.resetSelects();

            this.selectAll = !this.selectAll;

            if (this.selectAll === true) {
                const selects = document.querySelectorAll('[id^="select"]');

                selects.forEach((el) => this.selects.push(el.value));
            }
        },

        toggleSelect(id) {
            const index = this.selects.indexOf(id);

            if (index >= 0) {
                this.selects.splice(index, 1);
            } else {
                this.selects.push(id);
            }
        },

        resetSelects() {
            this.selects = [];
        },

        resetSelectAll() {
            this.selectAll = false;

            this.resetSelects();
        },

        highlight(event) {
            event.ids.forEach(function (id) {
                const row = document.querySelector(`#row-${id}`);

                if (!row) {
                    return;
                }

                const action = new Action(event.action);

                row.classList.add(...action.getClass());

                setTimeout(function () {
                    row.classList.remove(...action.getClass());
                }, 5000);
            });
        },
    };
}
