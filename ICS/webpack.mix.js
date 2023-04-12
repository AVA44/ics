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
    .js('resources/js/inventoryOpe/create.js', 'public/js')
    .js('resources/js/inventoryOpe/destroy.js', 'public/js')
    .js('resources/js/stockOpe/add/addStock.js', 'public/js')
    .js('resources/js/stockOpe/use/useStock.js', 'public/js')
    .js('resources/js/ajax/indexAjax.js', 'public/js')
    .js('resources/js/ajax/addStockAjax.js', 'public/js')
    .js('resources/js/ajax/useStockAjax.js', 'public/js')
    .autoload( {
    "jquery": [ '$', 'window.jQuery' ],
}  ).sass('resources/sass/app.scss', 'public/css');
