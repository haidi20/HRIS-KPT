const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.js('resources/js/app-210723.js', 'public/js').vue()
    .js('resources/js/app-notification.js', 'public/js').vue()
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();
