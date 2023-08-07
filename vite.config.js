import laravel from "laravel-vite-plugin";
import { defineConfig } from "vite";
import { viteStaticCopy } from "vite-plugin-static-copy";

export default defineConfig({
    server: {
        host: "0.0.0.0",
        port: 49205,
        hmr: {
            host: "localhost",
            protocol: "ws",
        },
    },
    plugins: [
        laravel({
            input: [
                "resources/sass/web.scss",
                "resources/sass/admin.scss",
                "resources/js/web.js",
                "resources/js/admin.js",
            ],
            refresh: true,
        }),
        viteStaticCopy({
            targets: [
                {
                    src: "node_modules/tinymce",
                    dest: "assets",
                },
                {
                    src: "resources/js/tinymce/langs",
                    dest: "assets/tinymce",
                },
            ],
        }),
    ],
});
