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
* procesando los scripts
*/
gulp.task('scripts', function() {
    return gulp.src('./public/src/js/*.js')
    .pipe(uglify().on('error', function(e){
            console.log(e);
         }))
    .pipe(gulp.dest('./public/dist/js/'))
    .pipe(notify({ title: "Scripts", message: "OK: Archivo Minificado" }));
});
/**
* default task
*/
gulp.task('default',['scripts']);
