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

elixir.config.sourcemaps = false;

var baseJsFiles = [
    "./bower_components/jquery/jquery.js",
    "./bower_components/bootstrap/js/alert.js",
    "./bower_components/bootstrap/js/collapse.js",
    "./bower_components/angular/angular.js",
    "./bower_components/angular-i18n/angular-locale_es-ar.js",
    "./bower_components/angular-animate/angular-animate.js",
    "./bower_components/angular-bootstrap/ui-bootstrap-tpls.js",
    "./resources/assets/js/app.js"
];

elixir(function(mix) {
    mix.less('styles.less', 'public/css/styles.css')
        .styles([
            './bower_components/bootstrap/dist/css/bootstrap.min.css',
            './bower_components/components-font-awesome/css/font-awesome.min.css'
        ], 'public/css/lib.css')
        .scripts(baseJsFiles, 'public/js/base.js')
        .scripts(['home.js'], 'public/js/home.js')
        .scripts(['products.js'], 'public/js/products.js')
        .scripts(['./bower_components/angular-confirm-modal/angular-confirm.js', 'cart.js'], 'public/js/cart.js')
        .copy('./bower_components/bootstrap/dist/fonts', 'public/fonts')
        .copy('./bower_components/components-font-awesome/fonts', 'public/fonts')
        .browserSync({
            proxy: 'local.rapinese'
        });
});

var exec = require('child_process').exec;

gulp.task('composer_install', function(cb) {
    exec('composer install');
});

gulp.task('bower_install', function(cb) {
    exec('bower install');
});

gulp.task('install', [
    'composer_install',
    'bower_install',
    'copy',
    'styles',
    'less',
    'scripts'
]);
