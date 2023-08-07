export default function dataTable() {
    return {
        selects: [],
        selectAll: false,
        actions: {
            active: ["alert", "alert-success"],
            inactive: ["alert", "alert-warning"],
            confirm: ["alert", "alert-primary"],
        },

        async init() {
            if (!this.$wire.$get("lazy")) {
                return;
            }

            if (window.innerWidth >= 1200) {
                this.$wire.$call("finishLazy");

                return;
            }

            let size;

            if (window.innerWidth < 768) {
                size = "sm";
            } else if (window.innerWidth < 992) {
                size = "md";
            } else if (window.innerWidth < 1200) {
                size = "lg";
            }

            await this.$wire.hideColumns(size);

            this.$wire.$call("finishLazy");
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
            const el = this;

            event.ids.forEach(function (id) {
                const row = document.querySelector(`#row-${id}`);

                if (!row) {
                    return;
                }

                row.classList.add(...el.actions[event.detail.action]);

                setTimeout(function () {
                    row.classList.remove(...el.actions[event.detail.action]);
                }, 5000);
            });
        },
    };
}
