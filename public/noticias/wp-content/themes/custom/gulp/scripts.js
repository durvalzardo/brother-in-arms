'use strict'

import gulp        from 'gulp';
import browserSync from 'browser-sync';
import browserify  from 'browserify';
import babelify    from 'babelify';
import source      from 'vinyl-source-stream';
import sourcemaps  from 'gulp-sourcemaps';
import buffer      from 'vinyl-buffer';
import uglify      from 'gulp-uglify';

browserSync.create();

gulp.task('javascript', () =>
  browserify('resources/assets/js/main.js')
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
