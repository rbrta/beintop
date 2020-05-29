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
.sass('resources/assets/scss/homepage.scss', 'public/css')
.sass('resources/assets/scss/clientpage.scss', 'public/css')
.sass('resources/assets/scss/backendpage.scss', 'public/css')

.js("resources/js/app.js", "public/js")
.js("resources/assets/js/main.js", "public/js");

mix.copyDirectory('resources/assets/images', 'public/images');

