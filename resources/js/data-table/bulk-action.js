export default function bulkAction() {
    return {
        loading: false,
        show: false,

        init() {
            this.$watch("selects", (value) => {
                this.show = false;

                if (value.length > 0) {
                    this.show = true;
                }
            });
        },

        async bulkAction(action) {
            this.loading = true;

            await this.$wire[action](this.selects);

            this.loading = false;
        },
    };
}
