export default function dataTable() {
    return {
        selects: [],
        selectAll: false,

        init() {
            let size;

            if (window.innerWidth < 768) {
                size = "sm";
            } else if (window.innerWidth < 992) {
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

                selects.forEach((el) => this.selects.push(parseInt(el.value)));
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
    };
}
