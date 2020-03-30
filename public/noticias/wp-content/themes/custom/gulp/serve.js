'use strict';

import gulp        from 'gulp';
import browserSync from 'browser-sync';

browserSync.create('static-boilerplate');

gulp.task('serve', ['build'], function() {
	browserSync.init({
    proxy: "http://localhost",
    files: ['resources/views/**/*.blade.php', 'app/**/*.php', 'config/*.php']
  });

	gulp.watch(['resources/assets/img/**/*'], ['images']);
	gulp.watch(['resources/assets/scss/**/*.scss'], ['css-minify']);
	gulp.watch(['resources/assets/js/**/*.js'], ['javascript']);
});
