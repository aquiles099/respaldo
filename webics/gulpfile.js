/**
*
*/
'use strict';
/**
*
*/
var gulp   = require('gulp');
var notify = require('gulp-notify');
var uglify = require('gulp-uglify');
/**
* Process[Scripts]
*/
gulp.task('scripts', function() {
    return gulp.src('./resources/assets/src/js/*.js')
    .pipe(uglify().on('error', function(e){
            console.log(e);
         }))
    .pipe(gulp.dest('./public/src/js/'))
    .pipe(notify({ title: "Scripts", message: "OK: Archivo Minificado" }));
});
gulp.task('default',['scripts']);
