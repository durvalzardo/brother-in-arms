'use strict';

import gulp         from 'gulp';
import autoprefixer from 'autoprefixer';
import browserSync  from 'browser-sync';
import cssImport    from 'postcss-import';
import path         from 'path';
import plumber      from 'gulp-plumber';
import postcss      from 'gulp-postcss';
import rename       from 'gulp-rename';
import sass         from 'gulp-sass';
import sourcemaps   from 'gulp-sourcemaps';
import uglifycss    from 'gulp-uglifycss';

var cssPlugins = [
  autoprefixer({ remove: false, browsers: '> 1%, last 2 versions, ie 9'}),
  cssImport
];

var onError = function (err) {
    console.log(err);
    this.emit('end');
};

browserSync.create();

gulp.task('css-compile', () =>
  gulp.src(['resources/assets/scss/*.scss', '!resources/assets/scss/_*.scss'])
    .pipe(plumber({ errorHandler: onError }))
    .pipe(sourcemaps.init())
    .pipe(sass())
    .pipe(postcss(cssPlugins))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('public/css'))
);

gulp.task('css-minify', ['css-compile'], () =>
  gulp.src(['public/css/*.css', '!public/css/*.min.css'])
    .pipe(uglifycss())
    .pipe(rename(function (path) {
      path.extname = '.min.css';
    }))
    .pipe(gulp.dest('public/css'))
    .pipe(browserSync.reload({ stream:true }))
);