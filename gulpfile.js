const gulp = require('gulp');
const htmlmin = require('gulp-htmlmin');
const terser = require('gulp-terser');
const cleanCSS = require('gulp-clean-css');
const rename = require('gulp-rename');
const replace = require('gulp-replace');

gulp.task('minify-html', () => {
  return gulp.src('src/*.html')
    .pipe(htmlmin({ 
        collapseWhitespace: true,
        minifyCSS: true,
        minifyJS: true
    }))
    .pipe(gulp.dest('dist'));
});

gulp.task('minify-styles', (done) => {
	gulp.src('src/css/*.css')
		.pipe(cleanCSS())
		.pipe(rename({suffix: '.min', extname: '.css'}))
		.pipe(gulp.dest('dist/css'))
		.on('error', function(err){
			console.error(err);
		});		

	done();
});

gulp.task('uglify-scripts', (done) => {
	gulp.src('src/js/*.js')
		.pipe(terser())
		.pipe(rename({extname: '.min.js'}))
		.pipe(gulp.dest('dist/js'))
		.on('error', function(err){
			console.error(err);
		});

	done();
})

gulp.task('cache-bust', (done) => {
	gulp.src('./dist/**/*.html')
		.pipe(replace(/cid=\d+/g, 'cid=' + new Date().getTime()))
		.pipe(gulp.dest('./dist/'))
		.on('error', function(err){
			console.error(err);
		});

	done();
})

gulp.task('default', gulp.series('minify-html', 'minify-styles', 'uglify-scripts', 'cache-bust'));
