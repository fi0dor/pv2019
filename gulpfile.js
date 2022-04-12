'use strict';

var gulp        = require('gulp');
var browserSync = require('browser-sync').create();
var sass        = require('gulp-sass')(require('sass'));
var notify      = require('gulp-notify');
var phpunit     = require('gulp-phpunit');
var reload      = browserSync.reload;

/* Task to compile SASS */
gulp.task('compile-sass', function() {  
	return gulp.src('public/css/**/style.scss')
		.pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('public/css'))
        .pipe(reload({stream: true}));
}); 

/* Task to watch SASS changes */
gulp.task('sass', function() {  
	gulp.watch('public/css/**/*.scss', gulp.series('compile-sass'));
});

/* Task to hot reload web server */
gulp.task('serve', function() {
    browserSync.init({
        proxy: 'localhost:8888',
        online: false,
		open: true,
        notify: false
    }); 

   	gulp.watch([
	    '**/*.php',
	    'public/css/**/*.scss',
	    'public/js/**/*.js',
	    'public/img/**/*'
	]).on("change", reload);
});

/* Task to run PHP unit tests */
gulp.task('run-phpunit', function() {
    var options = {debug: false, notify: true};

    gulp.src('tests/**/*.php')
        .pipe(phpunit('', options))
        .on('error', notify.onError({
            title: "Failed Tests!",
            message: "Error(s) occurred during testing..."
        }));
});

/* Task to watch PHP unit tests changes */
gulp.task('phpunit', function() {
    // gulp.watch('**/*.php', gulp.series('run-phpunit'));
});

/* Task when running `gulp` from terminal */
exports.default = gulp.parallel('sass', 'serve', 'phpunit');