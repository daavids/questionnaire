const mix = require('laravel-mix');

mix.setPublicPath('./')
   .js('src/resources/js/app.js', 'public/js')
   .sass('src/resources/sass/app.scss', 'public/css');
