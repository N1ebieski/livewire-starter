import axios from "axios";
import _merge from "lodash/merge";
import TomSelect from "tom-select";

export default function tomSelect(data) {
    if (!data.config.options.length) {
        delete data.config.options;
    }

    if (!data.config.items.length) {
        delete data.config.items;
    }

    if (!data.config.render.option) {
        delete data.config.render.option;
    }

    return {
        value: data.value,
        tomselect: null,

        init() {
            const el = this;

            this.tomselect = new TomSelect(
                el.$refs.tomselect,
                _merge(data.config, {
                    onInitialize: () => {
                        const tsDropdown = document.querySelector(
                            "body > .ts-dropdown"
                        );

                        const dropdowns = document.querySelector("#dropdowns");

                        dropdowns.appendChild(tsDropdown);
                    },
                    onChange: (newValue) => {
                        if (Array.isArray(newValue)) {
                            el.value = [];
                        }

                        el.value = newValue;

                        el.highlight(newValue);
                    },
                    ...(data.endpoint !== null && {
                        load: async function (query, callback) {
                            if (query.length < 3) {
                                callback();

                                return;
                            }

                            try {
                                const response = await axios.post(
                                    data.endpoint,
                                    {
                                        search: encodeURIComponent(query),
                                        except: data.except,
                                    }
                                );

                                callback(response.data);
                            } catch (error) {
                                callback();
                            }
                        },
                    }),
                    render: {
                        ...(data.config.render.option && {
                            option: new Function(
                                "data",
                                "escape",
                                data.config.render.option
                            ).bind(this),
                        }),
                        ...(data.lang === "pl" && {
                            no_results: function () {
                                return '<div class="no-results">Brak wyników</div>';
                            },
                            option_create: function (data, escape) {
                                return (
                                    '<div class="create">Dodaj <strong>' +
                                    escape(data.input) +
                                    "</strong>&hellip;</div>"
                                );
                            },
                        }),
                    },
                })
            );

            el.setValue(el.value);

            el.highlight(el.value);

            if (data.validation) {
                const observer = new MutationObserver((mutations) => {
                    mutations.forEach(function (mutation) {
                        if (mutation.target.classList.contains("is-valid")) {
                            return el.valid();
                        }

                        if (mutation.target.classList.contains("is-invalid")) {
                            return el.invalid();
                        }

                        return el.default();
                    });
                });

                observer.observe(el.$refs.valid, {
                    attributes: true,
                    attributeFilter: ["class"],
                });
            }
        },

        setValue(value) {
            if (value === null) {
                value = "";
            } else if (typeof value === "string") {
                value = value.split(",").map((item) => item.trim());
            }

            this.tomselect.setValue(value);
        },

        addItem(item) {
            if (item === null) {
                return;
            }

            this.tomselect.addOption({
                id: item[data.config.valueField],
                name: item[data.config.labelField],
            });

            this.tomselect.addItem(item[data.config.valueField]);

            this.highlight(this.value);
        },

        highlight(value) {
            if (!data.highlight) {
                return;
            }

            if (value && value.length) {
                this.activate();
            } else {
                this.deactivate();
            }
        },

        deactivate() {
            this.$refs.tomselect.nextElementSibling.classList.remove(
                "highlight"
            );
        },

        activate() {
            this.$refs.tomselect.nextElementSibling.classList.add("highlight");
        },

        default() {
            this.$refs.tomselect.nextElementSibling.classList.remove(
                "is-invalid"
            );
            this.$refs.tomselect.nextElementSibling.classList.remove(
                "is-valid"
            );
        },

        valid() {
            this.$refs.tomselect.nextElementSibling.classList.add(
                "form-select"
            );
            this.$refs.tomselect.nextElementSibling.classList.remove(
                "is-invalid"
            );
            this.$refs.tomselect.nextElementSibling.classList.add("is-valid");
        },

        invalid() {
            this.$refs.tomselect.nextElementSibling.classList.add(
                "form-select"
            );
            this.$refs.tomselect.nextElementSibling.classList.remove(
                "is-valid"
            );
            this.$refs.tomselect.nextElementSibling.classList.add("is-invalid");
        },

        destroy() {
            this.tomselect.destroy();
        },
    };
}
