import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
const themeInfo = require('./theme.json');
import path from 'path';

export default defineConfig({
    root: path.resolve(__dirname, '../../'),
    // publicDir: path.resolve(__dirname,`../../public/themes/${themeInfo.name.toLowerCase()}`),
    plugins: [
        laravel({
            input: path.resolve(__dirname,'./resources/js/app.js'),
            ssr:  path.resolve(__dirname,'./resources/js/ssr.js'),
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    // build: {
    //     outDir: path.resolve(__dirname,`../../public/themes/${themeInfo.name.toLowerCase()}/build`), 
    // },
    resolve: {
        alias: {
            '@': path.resolve(__dirname,'./resources/js'),
        }
    }
});
