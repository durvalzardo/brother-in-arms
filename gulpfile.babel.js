'use strict';

import gulp        from 'gulp';
import browserSync from 'browser-sync';
import browserify  from 'browserify';
import babelify    from 'babelify';
import source      from 'vinyl-source-stream';
import sourcemaps  from 'gulp-sourcemaps';
import buffer      from 'vinyl-buffer';
import uglify      from 'gulp-uglify';
import autoprefixer from 'autoprefixer';
import cssImport    from 'postcss-import';
import path         from 'path';
import plumber      from 'gulp-plumber';
import postcss      from 'gulp-postcss';
import rename       from 'gulp-rename';
import sass         from 'gulp-sass';
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

gulp.task('build', ['css', 'js']);

gulp.task('serve', ['build'], function() {
  browserSync.init({
    server: {
      baseDir: 'public',
      routes: {
        '/': '/index.html'
      }
    }
  });

  gulp.watch(['resources/assets/sass/**/*.scss'], ['css']);
  gulp.watch(['resources/assets/js/**/*.js'], ['js']);
});

gulp.task('css-compile', () =>
  gulp.src(['resources/assets/sass/*.scss', '!resources/assets/sass/_*.scss'])
    .pipe(plumber({ errorHandler: onError }))
    .pipe(sourcemaps.init())
    .pipe(sass())
    .pipe(postcss(cssPlugins))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('public/css'))
);

gulp.task('css', ['css-compile'], () =>
  gulp.src(['public/css/*.css', '!public/css/*.min.css'])
    .pipe(uglifycss())
    .pipe(rename(function (path) {
      path.extname = '.min.css';
    }))
    .pipe(gulp.dest('public/css'))
    .pipe(browserSync.reload({ stream:true }))
);

gulp.task('js', () =>
  browserify('resources/assets/js/app.js')
    .transform(babelify)
    .bundle()
    .on('error', function(err) {
      console.log(err);
      this.emit("end");
    })
    .pipe(source('bundle.js'))
    .pipe(buffer())
    .pipe(sourcemaps.init({loadMaps: true}))
    .pipe(uglify())
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('public/js'))
    .pipe(browserSync.reload({ stream:true }))
);