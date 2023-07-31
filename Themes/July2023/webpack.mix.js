const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('Themes/July2023/resources/js/app.js', 'public/js')
    .postCss('Themes/July2023/resources/css/app.css', 'public/css', [
        //
    ]);
