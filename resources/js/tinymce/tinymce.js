import _merge from "lodash/merge";

window.addEventListener("popstate", () => {
    if (!window.tinyMCE) {
        return;
    }

    /** @type {import("tinymce").TinyMCE} */
    const TinyMCE = window.tinyMCE;

    TinyMCE.remove();
});

// Fix https://github.com/tinymce/tinymce/issues/782
document.addEventListener("focusin", function (e) {
    if (
        e.target.closest(
            ".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root"
        ) !== null
    ) {
        e.stopImmediatePropagation();
    }
});

export default function tinyMCE(data) {
    return {
        value: data.value,

        init() {
            if (!window.tinyMCE) {
                return;
            }

            const el = this;

            /** @type {import("tinymce").TinyMCE} */
            const TinyMCE = window.tinyMCE;

            if (TinyMCE.get(`#${this.$refs.tinymce.id}`)) {
                return;
            }

            TinyMCE.suffix = "";
            TinyMCE.baseURL = window.location.origin + "/build/assets/tinymce";

            TinyMCE.init(
                _merge(
                    {
                        target: el.$refs.tinymce,
                        entity_encoding: "raw",
                    },
                    data.config,
                    {
                        ...(data.config.content_css === "dark" && {
                            content_style:
                                ".mce-content-body { background-color: #212529 !important; }",
                        }),
                        setup: function (editor) {
                            editor.on("blur", function () {
                                el.value = editor.getContent();
                            });

                            editor.on("init", function () {
                                if (el.value != null) {
                                    editor.setContent(el.value);
                                }
                            });

                            function putCursorToEnd() {
                                editor.selection.select(editor.getBody(), true);
                                editor.selection.collapse(false);
                            }

                            el.$watch("value", function (newValue) {
                                if (newValue !== editor.getContent()) {
                                    editor.resetContent(newValue || "");
                                    putCursorToEnd();
                                }
                            });
                        },
                    }
                )
            );

            const modal = el.$refs.tinymce.closest(".modal");

            if (modal) {
                modal.addEventListener("hidden.bs.modal", () => {
                    el.dispose();
                });
            }
        },

        dispose() {
            /** @type {import("tinymce").TinyMCE} */
            const TinyMCE = window.tinyMCE;

            TinyMCE.remove(`#${this.$refs.tinymce.id}`);
        },
    };
}
