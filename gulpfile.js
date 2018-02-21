
var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');

//style paths
var sass_files = 'module/Application/resources/sass/**/*.scss';
var js_files = 'module/Application/resources/js/**/*.js';
var css_dest = 'public/css/';
var js_dest = 'public/js/';

gulp.task('styles', function(){
    gulp.src(sass_files)
        .pipe(concat('style.css'))
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest(css_dest));
});

gulp.task('scripts', function(){
    gulp.src([
        'module/Application/resources/js/Validator.js',
        'module/Application/resources/js/validators/*.js',
        'module/Application/resources/js/validation.js',
        'module/Application/resources/js/main.js'
    ])
    .pipe(concat('script.js'))
    .pipe(gulp.dest(js_dest));
});


gulp.task('default', function(){
    gulp.start('styles');
});

gulp.task('watch',function() {
    gulp.start('styles');
    gulp.start('scripts');
    gulp.watch(sass_files,['styles']);
    gulp.watch(js_files,['scripts']);
});
