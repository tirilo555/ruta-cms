import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
<<<<<<< HEAD
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
=======
        // laravel({
        //     input: 'resources/js/app.js',
        //     ssr: 'resources/js/ssr.js',
        //     refresh: true,
        // }),
        vue({
            // template: {
            //     transformAssetUrls: {
            //         base: null,
            //         includeAbsolute: false,
            //     },
            // },
>>>>>>> d896113 (Created modules and themes. rendering views from theme. ssr)
        }),
    ],
    build: {
        // rollupOptions: {
        //     input: 'src/admin.js', // Ваша точка входу для адмінки
        // },
        outDir: 'Themes/July2023',
    }
});
