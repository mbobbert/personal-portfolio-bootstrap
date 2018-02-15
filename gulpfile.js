const gulp = require('gulp'),
      csso = require('gulp-csso'),
      sass = require('gulp-sass'),
      del  = require('del');

// Delete all CSS files
gulp.task('css:clean', function() {
	return del('dist/css/*.css', { force: true });
});

// Compile CSS
gulp.task('css:compile', ['css:clean'], function() {
	return gulp.src('src/scss/*.scss')
			.pipe(sass())
			.pipe(csso())
			.pipe(gulp.dest('dist/css'));
});

// Delete all PHP files
gulp.task('php:clean', function() {
	return del('dist/**/*.html', { force: true });
});

// Copy all PHP files
gulp.task('php:copy', ['php:clean'], function() {
	return gulp.src('src/**/*.php')
		.pipe(gulp.dest('dist/'));
});

// Delete all JavaScript files
gulp.task('js:clean', function() {
	return del('dist/js/*.js', { force: true });
});

// Copy all JavaScript files
gulp.task('js:copy', ['js:clean'], function() {
	return gulp.src('src/js/*.js')
		.pipe(gulp.dest('dist/js'));
});

// Delete all static files such as images etc.
gulp.task('img:clean', function() {
	return del([
			'dist/**/*', // delete all files
			'!dist/**/*.php', // except html
			'!dist/**/*.css' // except css
	], { force: true });
});

gulp.task('img:copy', ['img:clean'], function() {
	return gulp.src('src/img/**/*')
			.pipe(gulp.dest('dist/img'));
});

gulp.task('build', ['css:compile', 'php:copy', 'js:copy', 'img:copy']);

gulp.task('develop', ['build'], function() {
	gulp.watch('src/scss/*', ['css:compile']); // watch for changes in SCSS
	gulp.watch('src/**/*.php', ['php:copy']); // watch for changes in PHP
	gulp.watch('src/img/**/*', ['img:copy']); // watch for changes in static files
});