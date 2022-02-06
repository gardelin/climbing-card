let mix = require('laravel-mix');
mix.webpackConfig({
    externals: {
        jquery: 'jQuery',
    },
});

mix.options({
    enableCssModules: true,
});

// Define the public and resources paths
mix.setPublicPath('public/assets');
mix.setResourceRoot('../');
mix.options({processCssUrls: false});

// Compile admin scripts and styles
mix.js(['resources/assets/js/frontend/frontend.js'], 'public/assets/js');

mix.js('resources/assets/js/admin/admin.js', 'public/assets/js').vue();

mix.sass('resources/assets/sass/app.scss', 'public/assets/css');
mix.sass('resources/assets/sass/frontend.scss', 'public/assets/css');
mix.sass('resources/assets/sass/admin.scss', 'public/assets/css');
mix.copy('resources/assets/fonts', 'public/assets/fonts');

mix.sourceMaps();
mix.browserSync('https://vertikal.local');

if (mix.inProduction()) {
    mix.version();
}
