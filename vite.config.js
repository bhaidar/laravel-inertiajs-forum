import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';
import svgLoader from 'vite-svg-loader';

export default defineConfig({
    plugins: [
        svgLoader({
            svgo: false,
        }),
        laravel({
            input: 'resources/js/app.js',
            ssr: 'resources/js/ssr.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
                compilerOptions: {
                    isCustomElement: (tag) =>
                        [
                            'md-bold',
                            'md-link',
                            'md-at',
                            'md-code',
                            'md-italic',
                            'markdown-toolbar',
                        ].includes(tag),
                },
            },
        }),
    ],
});
