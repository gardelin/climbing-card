let mix = require('laravel-mix');
mix.webpackConfig({
    externals: {
        jquery: 'jQuery',
    },
});

// Define the public and resources paths
mix.setPublicPath('public/assets');
mix.setResourceRoot('../');

// Compile admin scripts and styles
mix.js(
    [
        'resources/assets/js/frontend.js',
        'resources/assets/js/legacy/jquery.tablesorter.js',
    ],
    'public/assets/js',
).sourceMaps();

// Compile legacy scripts from old plugin
mix.js(
    [
        'resources/assets/js/legacy/jquery.enumerable.js',
        'resources/assets/js/legacy/jquery.flot.js',
        'resources/assets/js/legacy/jquery.flot.pie.js',
        'resources/assets/js/legacy/jquery.lightbox_me.js',
        'resources/assets/js/legacy/jquery.tablescroll.js',
        'resources/assets/js/legacy/jquery.tablesorter.js',
        'resources/assets/js/legacy/jquery.ui.js',
        'resources/assets/js/legacy/ajaxsbmt.js',
        // 'resources/assets/js/legacy/raphael.js',
        'resources/assets/js/legacy/jquery.tufte-graph.js',
        'resources/assets/js/legacy/skripta.js',
        'resources/assets/js/legacy/cisti.js',
    ],
    'public/assets/js/legacy.js',
).sourceMaps();

mix.sass('resources/assets/sass/app.scss', 'public/assets/css').sourceMaps();
mix.sass(
    'resources/assets/sass/frontend.scss',
    'public/assets/css',
).sourceMaps();
