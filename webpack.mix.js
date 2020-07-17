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
<<<<<<< HEAD
    .sass('resources/sass/app.scss', 'public/css')
    .sass('node_modules/three-dots/sass/three-dots.scss', 'public/css');
=======
    .sass('resources/sass/app.scss', 'public/css');
>>>>>>> 0bbad4b12acda410c74ae099dfdf3e65c08fb551
