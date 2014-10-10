var gulp = require('gulp'),
  sass = require('gulp-sass'),
  autoprefix = require('gulp-autoprefixer'),
  sourcemaps = require('gulp-sourcemaps'),
  rename = require('gulp-rename'),
  concat = require('gulp-concat'),
  minifycss = require('gulp-minify-css'),
  imagemin = require('gulp-imagemin'),
  pngcrush = require('imagemin-pngcrush'),
  jshint = require('gulp-jshint'),
  uglify = require('gulp-uglify'),
  modernizr = require('gulp-modulizr'),
  livereload = require('gulp-livereload'),
  stylish = require('jshint-stylish'),
  rev = require('gulp-rev');

var paths = {
  scripts: [
    'assets/vendor/fastclick/lib/fastclick.js',
    'assets/vendor/foundation/js/foundation/foundation.js',
    'assets/vendor/foundation/js/foundation/foundation.abide.js',
    'assets/vendor/foundation/js/foundation/foundation.accordion.js',
    'assets/vendor/foundation/js/foundation/foundation.alert.js',
    'assets/vendor/foundation/js/foundation/foundation.clearing.js',
    'assets/vendor/foundation/js/foundation/foundation.dropdown.js',
    'assets/vendor/foundation/js/foundation/foundation.equalizer.js',
    'assets/vendor/foundation/js/foundation/foundation.interchange.js',
    'assets/vendor/foundation/js/foundation/foundation.joyride.js',
    'assets/vendor/foundation/js/foundation/foundation.magellan.js',
    'assets/vendor/foundation/js/foundation/foundation.offcanvas.js',
    'assets/vendor/foundation/js/foundation/foundation.orbit.js',
    'assets/vendor/foundation/js/foundation/foundation.reveal.js',
    'assets/vendor/foundation/js/foundation/foundation.slider.js',
    'assets/vendor/foundation/js/foundation/foundation.tab.js',
    'assets/vendor/foundation/js/foundation/foundation.tooltip.js',
    'assets/vendor/foundation/js/foundation/foundation.topbar.js',
    'assets/js/plugins/*.js',
    'assets/js/_*.js'
  ],
  jshint: [
    'gulpfile.js',
    'assets/js/*.js',
    '!assets/js/scripts.js',
    '!assets/js/scripts.min.js',
    '!assets/**/*.min-*'
  ],
  sass: 'assets/scss/main.scss'
};

var destination = {
  css: 'assets/css',
  scripts: 'assets/js',
  vendor: 'assets/js/vendor'
};

gulp.task('sass', function() {
  return gulp.src(paths.sass)
    .pipe(sourcemaps.init())
    .pipe(sass({ errLogToConsole: true }))
    .pipe(autoprefix('last 2 versions', 'ie 9', 'android 2.3', 'android 4', 'opera 12'))
    .pipe(rename('./main.css'))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(destination.css))
    .pipe(minifycss())
    .pipe(rename('./main.min.css'))
    .pipe(gulp.dest(destination.css))
    .pipe(livereload({ auto: false }));
});

gulp.task('jshint', function() {
  return gulp.src(paths.jshint)
    .pipe(jshint())
    .pipe(jshint.reporter(stylish));
});

gulp.task('js', ['jshint'], function() {
  return gulp.src(paths.scripts)
    .pipe(concat('./scripts.js'))
    .pipe(gulp.dest(destination.scripts))
    .pipe(uglify())
    .pipe(rename('./scripts.min.js'))
    .pipe(gulp.dest(destination.scripts))
    .pipe(livereload({ auto: false }));
});

gulp.task('modernizr', function() {
  return gulp.src('assets/vendor/modernizr/modernizr.js')
    .pipe(modernizr(
      (['inlinesvg', 'svg', 'svgclippaths', 'touch', 'shiv', 'mq', 'cssclasses', 'teststyles', 'prefixes', 'load'])
    ))
    .pipe(gulp.dest(destination.vendor))
    .pipe(uglify())
    .pipe(rename('./modernizr.min.js'))
    .pipe(gulp.dest(destination.vendor));
});

gulp.task('version', function() {
  return gulp.src(['assets/css/main.min.css', 'assets/js/scripts.min.js'], { base: 'assets' })
    .pipe(rev())
    .pipe(gulp.dest('assets'))
    .pipe(rev.manifest())
    .pipe(gulp.dest('assets'));
});

gulp.task('imagemin', function() {
  return gulp.src(['assets/img/*', '!assets/img/*.svg'])
    .pipe(imagemin({
      progressive: true,
      svgoPlugins: [{removeViewBox: false}],
      use: [pngcrush()]
    }))
    .pipe(gulp.dest('assets/img/'));
});

gulp.task('watch', function() {
  livereload.listen();
  gulp.watch('assets/scss/**/*.scss', ['sass']);
  gulp.watch('assets/js/**/*.js', ['jshint', 'js']);
  gulp.watch('assets/img/*', ['imagemin']);
  gulp.watch('**/*.php').on('change', function(file) {
    livereload.changed(file.path);
  });
});

gulp.task('default', ['sass', 'jshint', 'js', 'modernizr']);
gulp.task('dev', ['default']);
gulp.task('build', ['sass', 'jshint', 'js', 'imagemin', 'modernizr', 'version']);
