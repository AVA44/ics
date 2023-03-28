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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/index.js', 'public/js')
    .js('resources/js/create.js', 'public/js')
    .js('resources/js/addStock.js', 'public/js')
    .js('resources/js/useStock.js', 'public/js')
    .js('resources/js/destroy.js', 'public/js')
    .js('resources/js/indexAjax.js', 'public/js')
    .js('resources/js/addStockAjax.js', 'public/js')
    .js('resources/js/useStockAjax.js', 'public/js')
    .autoload( {
    "jquery": [ '$', 'window.jQuery' ],
}  ).sass('resources/sass/app.scss', 'public/css');
