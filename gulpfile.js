const gulp = require('gulp');
const zip = require('gulp-zip');
var prompt = require('gulp-prompt');
var replace = require('gulp-replace');
var pjson = require('./package.json');

const path = {
    dist: 'dist/',
};

gulp.task('dist', function () {
    return gulp.src(['**/*', '!**/.*', '!{dist,dist/**}', '!{node_modules,node_modules/**}', '!{resources/assets,resources/assets/**}', '!composer.json', '!composer.lock', '!prettierignore.lock', '!prettierrc.json', '!gulpfile.js', '!package.json', '!webpack.mix.js', '!package-lock.json', '!.gitignore', '!todo.txt'], { base: '../' }).pipe(zip('climbing-card.zip')).pipe(gulp.dest(path.dist));
});

/**
 * Changes the version of the theme based
 * on user input in various files
 */
gulp.task('version', function () {
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
                    .pipe(replace(/\sStable\stag:\s.+/g, 'Stable tag: ' + res.version))
                    // activation.php
                    .pipe(replace(/define\(\'CLIMBING_CARD_VERSION\'\,\s\'.+\'\)\;/g, "define('CLIMBING_CARD_VERSION', '" + res.version + "');"))
                    .pipe(replace(/Version:\s.+/g, 'Version: ' + res.version))
                    .pipe(gulp.dest('./'));

                console.log('Version set to "' + res.version + '".');
            },
        ),
    );
});
