const gulp = require('gulp');
const zip = require('gulp-zip');
var prompt = require('gulp-prompt');
var replace = require('gulp-replace');
var run = require('gulp-run');
var fs = require('fs');
const { series } = require('gulp');

const path = {
    dist: 'dist/',
};

gulp.task('zip', function () {
    var json = JSON.parse(fs.readFileSync('./package.json'));
    const version = json.version;
    const zipName = `climbing-card-v${version}.zip`;

    console.info('Generating /dist/' + zipName);

    return gulp.src(['**/*', '!**/.*', '!{dist,dist/**}', '!{node_modules,node_modules/**}', '!{resources/assets,resources/assets/**}', '!composer.json', '!composer.lock', '!prettierignore.lock', '!prettierrc.json', '!gulpfile.js', '!package.json', '!webpack.mix.js', '!package-lock.json', '!.gitignore', '!todo.txt'], { base: '../' }).pipe(zip(zipName)).pipe(gulp.dest(path.dist));
});

/**
 * Changes the version of the plugin based
 * on user input in various files
 */
gulp.task('version', function () {
    var pjson = require('./package.json');

    return gulp.src(['package.json']).pipe(
        prompt.prompt(
            {
                type: 'input',
                name: 'version',
                message: 'Enter the new version (current version is ' + pjson.version + '):',
            },
            function (res) {
                // If user doesn't input the version, don't change it)
                if (!res.version) {
                    console.warn('Version has not been changed.');
                    return;
                }

                gulp.src(['package.json', 'readme.txt', 'readme.txt', 'activation.php', 'activation.php'])
                    // package.json
                    .pipe(replace(/\"version\": \".+\",/g, '"version": "' + res.version + '",'))
                    // readme.txt
                    .pipe(replace(/Current\sversion:\s.+/g, 'Current version: ' + res.version))
                    .pipe(replace(/Stable\stag:\s.+/g, 'Stable tag: ' + res.version))
                    // activation.php
                    .pipe(replace(/define\(\'CLIMBING_CARD_VERSION\'\,\s\'.+\'\)\;/g, "define('CLIMBING_CARD_VERSION', '" + res.version + "');"))
                    .pipe(replace(/Version:\s.+/g, 'Version: ' + res.version))
                    .pipe(gulp.dest('./'));

                console.log('Version set to "' + res.version + '".');
            },
        ),
    );
});

gulp.task('prod', function () {
    return run('npm run prod').exec();
});

gulp.task('release', series('version', 'prod', 'zip'));
