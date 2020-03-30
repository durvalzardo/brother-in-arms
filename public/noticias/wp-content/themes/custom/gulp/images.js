'use strict';

import gulp     from 'gulp';
import imagemin from 'gulp-imagemin';

gulp.task('images', () =>
  gulp.src('resources/assets/img/**/*')
    .pipe(imagemin({
      progressive: true,
      interlaced: true
    }))
    .pipe(gulp.dest('public/img'))
);