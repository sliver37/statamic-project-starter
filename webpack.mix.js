const mix = require('laravel-mix');
const path = require('path');
const tailwindcss = require('tailwindcss');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/site.js', 'public/js').vue().sourceMaps();

mix.webpackConfig({
    resolve: {
        extensions: [".ts", ".tsx", ".js", ".jsx", ".vue", "*"],
        alias: {
            '~': path.join(__dirname, 'public/assets/')
        },
    },
})

mix.sass('resources/scss/styles.scss', 'public/css')
    .options({
        postCss: [tailwindcss('./tailwind.config.js')],
    });

if (mix.inProduction()) {
    mix.version();
}

/*
 |--------------------------------------------------------------------------
 | Statamic Control Panel
 |--------------------------------------------------------------------------
 |
 | Feel free to add your own JS or CSS to the Statamic Control Panel.
 | https://statamic.dev/extending/control-panel#adding-css-and-js-assets
 |
 */

// mix.js('resources/js/cp.js', 'public/vendor/app/js')
//    .postCss('resources/css/cp.css', 'public/vendor/app/css', [
//     require('postcss-import'),
//     require('tailwindcss'),
//     require('postcss-nested'),
//     require('postcss-preset-env')({stage: 0})
// ])
