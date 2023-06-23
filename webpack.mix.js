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

mix.override(webpackConfig => {
    const chunkFileName = webpackConfig.output.chunkFilename;

    webpackConfig.output.chunkFilename = (pathData, assetInfo) => {
        return `${chunkFileName(pathData, assetInfo)}?id=[chunkhash]`;
    };
});

mix.js('resources/js/app.js', 'public/js').vue({ version: 2 })
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();
