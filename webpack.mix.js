let mix = require('laravel-mix');

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

// Was moved from resources/assets to rescources/laravel_assets
// mix.js('resources/assets/js/app.js', 'public/js')
//     .sass('resources/assets/sass/app.scss', 'public/css');


/*
* Medniy template
* */
mix.styles([
    'resources/assets/vendor/bootstrap/css/bootstrap.min.css',
    'resources/assets/vendor/animate.css',
    'resources/assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.min.css',
], 'public/assets/css/lib.css');

mix.styles([
    'resources/assets/css/main.css',
    'resources/assets/css/mobile.css',
], 'public/assets/css/template.css');

mix.babel([
    'resources/assets/vendor/jquery/dist/jquery.min.js',
    'resources/assets/vendor/jquery-mobile.js',
    'resources/assets/vendor/bootstrap/js/bootstrap.min.js',
    'resources/assets/vendor/jquery.inputmask.bundle.js',
    'resources/assets/vendor/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js',
    'resources/assets/vendor/jquery.paroller.min.js',
    'resources/assets/vendor/scrollreveal.min.js',
    'resources/assets/vendor/imagesloaded.pkgd.min.js',
], 'public/assets/js/lib.js');

mix.babel([
    'resources/assets/js/main.js',
], 'public/assets/js/template.js');
