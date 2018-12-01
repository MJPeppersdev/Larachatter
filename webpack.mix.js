let mix = require('laravel-mix');
var path = require('path');

mix.js('resources/js/bootstrap.js', 'publishable/public/js/larachat.js')
   .sass('resources/sass/larachat.scss', 'publishable/public/css/larachat.css')
   .options({
      processCssUrls: false
   })
   .webpackConfig({
      resolve: {
         modules: [
            path.resolve(__dirname, 'vendor/launcher/larachatter/resources/js'),
            'node_modules'
         ],
         alias: {
            'vue$': 'vue/dist/vue.js'
         }
      }
   });
