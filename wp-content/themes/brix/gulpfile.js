const gulp = require('gulp');
const sass = require('gulp-sass');
const sassGlob = require('gulp-sass-glob');
const del = require('del');

gulp.task('styles', () => {
    return gulp.src('scss/styles.scss')
        .pipe(sassGlob())
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./assets/css/'));
});

gulp.task('clean', () => {
    return del([
        'assets/css/main.css',
    ]);
});

gulp.task('default', gulp.series(['clean', 'styles']));
