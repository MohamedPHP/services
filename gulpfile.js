var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

require('laravel-elixir-vueify');

elixir(function(mix) {
    /*start frontend*/
    mix.styles([
        'bootstrap.min.css',
        'font-awesome.min.css',
        'sweetalert.css',
        'alertify.core.css',
        'alertify.default.css',
        'fontawesome-stars.css',
        'styles.css',
    ], 'public/frontend/css/style.css');

    mix.scripts([
        'lips/jquery.min.js',
        'lips/bootstrap.min.js',
        'lips/sweetalert.min.js',
        'lips/alertify.min.js',
        'lips/jquery.barrating.min.js',
        'lips/application.js',
    ], 'public/frontend/js/main.js');
    /*end frontend*/

    /*start admin*/
    mix.styles([
        'admin/bootstrap.min.css',
        'font-awesome.min.css',
        'sweetalert.css',
        'admin/buttons.css',
        'admin/styles.css',
    ], 'public/admin/css/main.css');

    mix.scripts([
        'lips/jquery.min.js',
        'admin/bootstrap.min.js',
        'lips/sweetalert.min.js',
        'admin/custom.js',
    ], 'public/admin/js/main.js');
    /*end admin*/

    mix.browserify([
        'app.js',
    ], 'public/frontend/js/app.js');



});
