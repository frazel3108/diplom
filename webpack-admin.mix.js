const mix = require('laravel-mix');
const path = require('path');

require('laravel-mix-merge-manifest');

mix
    .js('resources/admin/js/app.js', 'public/admin/js')
    .vue()
    .sass('resources/admin/css/main.scss', 'public/admin/css')
    .options({
        postCss: [
            require("postcss-import"),
            require('tailwindcss')('tailwind-admin.config.js'),
            require("autoprefixer"),
        ]
    })
    .webpackConfig({
        output: {
            chunkFilename: 'js/chunks/[name].js',
        },
        resolve: {
            alias: {
                '@': path.resolve('resources/admin/js'),
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
