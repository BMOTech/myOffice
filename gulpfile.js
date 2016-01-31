var gulp = require('gulp'),
    sass = require('gulp-sass'),
    browserSync = require('browser-sync'),
    sourcemaps = require('gulp-sourcemaps'),
    source = require('vinyl-source-stream'),
    buffer = require('vinyl-buffer'),
    concat = require('gulp-concat'),
    browserify = require('browserify');

// Copy
gulp.task('copy', function() {
    gulp.src('./node_modules/font-awesome/fonts/**.*')
        .pipe(gulp.dest('./public/fonts'));
    gulp.src('./node_modules/bootstrap-sass/assets/fonts/**/**.*')
        .pipe(gulp.dest('./public/fonts'));
    gulp.src('./node_modules/fullcalendar/dist/fullcalendar.css')
        .pipe(gulp.dest('./public/css'));
});

// CSS
gulp.task('scss', function() {
    gulp.src('./src/assets/sass/style.scss')
        .pipe(sourcemaps.init())
        .pipe(sass()).on('error', sass.logError)
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('./public/css'))
        .pipe(browserSync.reload({
            stream: true
        }))
});

// JavaScript
gulp.task('js', function() {
    gulp.src([
            './node_modules/jquery/dist/jquery.js',
            './node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
            './node_modules/moment/min/moment-with-locales.js',
            './node_modules/fullcalendar/dist/fullcalendar.js',
            './node_modules/fullcalendar/dist/lang/de.js'])
        .pipe(sourcemaps.init())
        .pipe(concat('libraries.js'))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('public/js'));
});

gulp.task('browserify', function() {
    // Grabs the app.js file
    return browserify('src/assets/js/app.js')
    // bundles it and creates a file called main.js
        .bundle()
        .pipe(source('main.js'))
        // saves it the public/js/ directory
        .pipe(gulp.dest('public/js/'));
})

// BrowserSync
gulp.task('browserSync', function() {
    browserSync({
        proxy: {
            target: "office.app"
        }
    })
});

// Rerun the task when a file changes
gulp.task('watch', ['browserSync', 'scss', 'js'], function(){
    gulp.watch('src/assets/sass/**/*.scss', ['scss']);
    gulp.watch('src/assets/js/**/*.*', ['js', 'browserify']);
    gulp.watch('public/*.php', browserSync.reload);
    gulp.watch('public/js/*.js', browserSync.reload);
});

// Default task
gulp.task('default', ['scss', 'copy', 'js']);
