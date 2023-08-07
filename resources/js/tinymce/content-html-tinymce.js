import tinymce from "tinymce";

window.contentHtmlTinyMCE = (config) => {
    return {
        theme: config.theme,
        lang: config.lang ?? "en",
        livewire: config.livewire ?? true,
        value: config.value ?? "",

        init() {
            const el = this;
            const modal = document.querySelector(".modal");

            modal.addEventListener("hidden.bs.modal", () => {
                tinymce.remove();
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

            tinymce.init({
                target: el.$refs.tinymce,
                entity_encoding : "raw",
                skin: el.theme === "dark" ? "tinymce-5-dark" : "tinymce-5",
                content_css: el.theme === "dark" ? "dark" : "default",
                plugins: "fullscreen image link table lists code autoresize",
                toolbar:
                    "code | undo redo | styles | bold italic | numlist bullist | link image hr | fullscreen",
                mobile: {
                    menubar: true,
                    toolbar_mode: "floating",
                },
                language: el.lang,
                ...(el.theme === "dark" && {
                    content_style:
                        ".mce-content-body { background-color: #212529 !important; }",
                }),
                ...(el.livewire === true && {
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
                }),
            });
        },
    };
};
