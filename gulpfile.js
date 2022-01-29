const gulp = require('gulp');
const zip = require('gulp-zip');

const path = {
    dist: 'dist/',
};

gulp.task('dist', function () {
    return gulp
        .src(
            [
                '**/*',
                '!**/.*',
                '!{dist,dist/**}',
                '!{node_modules,node_modules/**}',
                '!{resources/assets,resources/assets/**}',
                '!composer.json',
                '!composer.lock',
                '!prettierignore.lock',
                '!prettierrc.json',
                '!gulpfile.js',
                '!package.json',
                '!webpack.mix.js',
                '!package-lock.json',
                '!.gitignore',
                '!todo.txt',
            ],
            {base: '../'},
        )
        .pipe(zip('climbing-card.zip'))
        .pipe(gulp.dest(path.dist));
});
