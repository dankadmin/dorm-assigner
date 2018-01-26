
var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');

//style paths
var sass_files = 'module/Application/resources/sass/**/*.scss';
var css_dest = 'public/css/';

gulp.task('styles', function(){
    gulp.src(sass_files)
        .pipe(concat('style.css'))
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest(css_dest));
});


gulp.task('default', function(){
    gulp.start('styles');
});

gulp.task('watch',function() {
    gulp.start('styles');
    gulp.watch(sass_files,['styles']);
});
