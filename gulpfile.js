var elixir = require('laravel-elixir');
elixir.config.sourcemaps = false;

var gulp = require('gulp');

elixir(function (mix) {
    // compile sass to css
    mix.sass('resources/assets/sass/app.scss', 'resources/assets/css');

    //combine css file
    mix.styles(

        [
            'css/app.css',
            'bower/vendor/slick-carousel/slick/slick.css'

        ], 'public/css/all.css', // output file is here

    'resources/assets'
    );

    var bowerPath = 'bower/vendor';

    mix.scripts(
        [
            //jQuery
            bowerPath + '/jQuery/dist/jquery.min.js',

            //foundation js
            bowerPath + '/foundation-sites/dist/js/foundation.min.js',

            //other dependencies
            bowerPath + '/slick-carousel/slick/slick.min.js',

            //Chart.js
            bowerPath + '/chart.js/dist/Chart.bundle.js',

            //axios dependencies
            bowerPath + '/axios/dist/axios.min.js',

            // all js files in js folder
            'js/acme.js',
            'js/admin/*.js',
            'js/pages/*.js',
            'js/init.js'

        ], 'public/js/all.js',

        'resources/assets'
    );

});