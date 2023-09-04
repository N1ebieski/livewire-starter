import { default as TarekraafatAutoComplete } from "@tarekraafat/autocomplete.js";
import axios from "axios";
import _merge from "lodash/merge";

export default function autoComplete(data) {
    if (!data.config.query) {
        delete data.config.query;
    }

    if (!data.config.events.input.selection) {
        delete data.config.events.input.selection;
    }

    return {
        value: data.value,
        autocomplete: null,

        init() {
            const el = this;

            this.autocomplete = new TarekraafatAutoComplete(
                _merge(
                    {
                        selector: `#${el.$refs.autocomplete.id}`,
                        wrapper: false,
                        threshold: 3,
                        resultsList: {
                            class: "dropdown-menu show",
                        },
                        resultItem: {
                            highlight: true,
                            class: "dropdown-item",
                        },
                        events: {
                            input: {
                                selection: (event) => {
                                    const selection =
                                        event.detail.selection.value;

                                    el.autocomplete.input.value = selection;
                                },
                            },
                        },
                    },
                    data.config,
                    {
                        data: {
                            ...(data.endpoint !== null && {
                                src: async function (query) {
                                    if (query.length < 3) {
                                        return;
                                    }

                                    try {
                                        const response = await axios.post(
                                            data.endpoint,
                                            {
                                                search: encodeURIComponent(
                                                    query
                                                ),
                                                except: data.except,
                                            }
                                        );

                                        return response.data;
                                    } catch (error) {
                                        return error;
                                    }
                                },
                            }),
                        },
                        events: {
                            input: {
                                ...(data.config.events.input.selection && {
                                    selection: new Function(
                                        "event",
                                        data.config.events.input.selection
                                    ).bind(this),
                                }),
                            },
                        },
                        ...(data.config.query && {
                            query: new Function(
                                "input",
                                data.config.query
                            ).bind(this),
                        }),
                    }
                )
            );

            el.highlight(el.value);

            el.$refs.autocomplete.addEventListener("change", (event) => {
                el.value = event.target.value;

                el.highlight(event.target.value);
            });

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

        destroy() {
            this.autocomplete.unInit();

            this.$refs.autocomplete.nextElementSibling.remove();
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
            this.$refs.autocomplete.classList.remove("highlight");
        },

        activate() {
            this.$refs.autocomplete.classList.add("highlight");
        },

        default() {
            this.$refs.autocomplete.classList.remove("is-invalid");
            this.$refs.autocomplete.classList.remove("is-valid");
        },

        valid() {
            this.$refs.autocomplete.classList.remove("is-invalid");
            this.$refs.autocomplete.classList.add("is-valid");
        },

        invalid() {
            this.$refs.autocomplete.classList.remove("is-valid");
            this.$refs.autocomplete.classList.add("is-invalid");
        },
    };
}
