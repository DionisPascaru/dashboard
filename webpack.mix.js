const mix = require('laravel-mix');
const path = require('path');

mix.js('resources/js/app.js', 'public/js').vue(); // Use .vue() for Vue.js projects
mix.sass('resources/sass/app.scss', 'public/css');
mix.postCss('resources/css/app.css', 'public/css');

mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources'),
        },
    },
});
