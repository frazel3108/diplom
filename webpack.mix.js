const mix = require('laravel-mix');
const path = require('path');

require('laravel-mix-merge-manifest');

mix
    .js('resources/js/app.js', 'public/js')
    .vue()
    .css('resources/css/app.css', 'public/css')
    .options({
        postCss: [
            require("postcss-import"),
            require('tailwindcss')('tailwind.config.js'),
            require("autoprefixer"),
        ]
    })
    .webpackConfig({
        output: {
            chunkFilename: 'js/chunks/[name].js',
        },
        resolve: {
            alias: {
                '@': path.resolve('resources/js/vue'),
            },
        },
        module: {
            rules: [
                {
                    test: /\.(postcss)$/,
                    use: [
                        'vue-style-loader',
                        { loader: 'css-loader', options: { importLoaders: 1 } },
                        'postcss-loader'
                    ]
                }
            ]
        }
    });

if (!mix.inProduction()) {
    mix.sourceMaps();
}
