import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        vue({
            template: {
                compilerOptions: {
                    isCustomElement: (tag) => ['md-linedivider'].includes(tag),
                }
            }
        }),
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.esm-bundler.js' // Use of WebPack 1 you need to use 'Vue / Dist / Vue.common.js'
        }
    }
});
