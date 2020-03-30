'use strict';

import gulp from 'gulp';

import './gulp/serve';
import './gulp/scripts';
import './gulp/styles';
import './gulp/images';

gulp.task('build', ['css-minify', 'javascript', 'images']);
gulp.task('build-admin', ['css-admin', 'javascript-admin']);
gulp.task('default', ['serve']);
