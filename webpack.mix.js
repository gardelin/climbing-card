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
);

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
        // Raphael is commented because it's not working when
        // bundeled with webpack
        // instead just copying it separately
        // 'resources/assets/js/legacy/raphael.js',
        'resources/assets/js/legacy/jquery.tufte-graph.js',
        'resources/assets/js/legacy/skripta.js',
        'resources/assets/js/legacy/cisti.js',
    ],
    'public/assets/js/legacy.js',
);

mix.js('resources/assets/js/admin.js', 'public/assets/js').vue();

mix.sass('resources/assets/sass/app.scss', 'public/assets/css');
mix.sass('resources/assets/sass/frontend.scss', 'public/assets/css');

mix.copy(
    'resources/assets/js/legacy/raphael.js',
    'public/assets/js/legacy/raphael.js',
);

mix.sourceMaps();

if (mix.inProduction()) {
    mix.version();
}
