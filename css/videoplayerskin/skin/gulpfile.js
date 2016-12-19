'use strict';

// Let's GO!
var gulp         = require('gulp'),
    browserSync  = require('browser-sync').create(),
    reload       = browserSync.reload,
    sass         = require('gulp-sass'),
    useref       = require('gulp-useref'),
    gulpif       = require('gulp-if'),
    uglify       = require('gulp-uglify'),
    minifyCss    = require('gulp-minify-css'),
    autoprefixer = require('gulp-autoprefixer'),
    sourcemaps   = require('gulp-sourcemaps');


// --------------------------------------------------------
// LiveReload with BrowserSync
// --------------------------------------------------------
gulp.task('serve', ['sass'], function() {
    browserSync.init({
        server: {
            baseDir: ['src']
        },
        //tunnel: "fwlab", //open external access to this server
        //host: 'metaform-lab',
        open: "local",
        port: 3000,
        online: true, // if you're working offline set to false this item retuce startUp time
        logPrefix: "Polyzor Skin"

    });
    //set watcher
    gulp.watch('src/*.html').on('change', browserSync.reload);
    gulp.watch('src/css/*.css').on('change', browserSync.reload);

    gulp.watch(['src/polyzor-skin/**/*.scss'], ['sass']);
});

// --------------------------------------------------------
// Compile SASS & CSS autoprefixer
// --------------------------------------------------------

gulp.task('sass', function () {
  gulp.src('src/polyzor-skin/**/*.scss')
    .pipe(sourcemaps.init())
      .pipe(sass.sync().on('error', sass.logError))
      .pipe(autoprefixer({
        browsers: ['last 10 versions'],
        cascade: true
    }))
    .pipe(sass({outputStyle: 'compressed'}))
    .pipe(sourcemaps.write('/'))
    //.pipe(browserSync.stream())
    .pipe(gulp.dest('src/css'));
});

// --------------------------------------------------------
// Concat CSS & JS
// --------------------------------------------------------
gulp.task('concat', function () {
    var assets = useref.assets();

    return gulp.src('src/*.html')
        .pipe(assets)
        .pipe(gulpif('*.css', minifyCss()))
        .pipe(assets.restore())
        .pipe(useref())
        .pipe(gulp.dest('dist'));
});

// --------------------------------------------------------
// Prepare files for PRODUCTION
// --------------------------------------------------------
gulp.task('dist', ['concat']);

// --------------------------------------------------------
// Create production ver. and Run!
// --------------------------------------------------------
gulp.task('serve:dist', ['dist'], function() {
    browserSync.init({
        server: {
            baseDir: ['dist']
        }
    });
});

