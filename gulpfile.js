var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.scripts([
        'bower_components/jquery/dist/jquery.js',
        'bower_components/angular/angular.js',
        'bower_components/angular-sanitize/angular-sanitize.js',
        'bower_components/bootstrap/dist/js/bootstrap.js',
        'bower_components/angular-cookies/angular-cookies.js',
        'bower_components/moment/moment.js',
        'bower_components/bootstrap-select/dist/js/bootstrap-select.js',
        'bower_components/angular-bootstrap-select/build/angular-bootstrap-select.js',
        'bower_components/bootstrap-daterangepicker/daterangepicker.js',
        'bower_components/angular-daterangepicker/js/angular-daterangepicker.js',
        'bower_components/angular-bootstrap/ui-bootstrap-tpls.js',
        'resources/assets/vendor/grid/js/angular.init.js',
        'resources/assets/vendor/grid/js/ngGrid.js'
    ], 'public/js/scripts.js', '.');

    mix.styles([
        'bower_components/bootstrap/dist/css/bootstrap.css',
        'bower_components/font-awesome/css/font-awesome.css',
        'bower_components/bootstrap-select/dist/css/bootstrap-select.css',
        'bower_components/bootstrap-daterangepicker/daterangepicker.css',
        'resources/assets/vendor/grid/css/grid.css'
    ], 'public/css/styles.css', '.');

    mix.copy(
        'bower_components/bootstrap/dist/fonts',
        'public/fonts'
    );
    mix.copy(
        'bower_components/font-awesome/fonts',
        'public/fonts'
    );
});
