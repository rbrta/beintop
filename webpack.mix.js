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

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css');

mix
.sass('resources/sass/homepage.scss', 'public/css')
.sass('resources/sass/clientpage.scss', 'public/css')
.sass('resources/sass/backendpage.scss', 'public/css')

.js("resources/js/app.js", "public/js")
.js("resources/js/main.js", "public/js");

mix.copyDirectory('resources/images', 'public/images');

