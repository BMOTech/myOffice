var gulp = require('gulp'),
    sass = require('gulp-sass'),
    browserSync = require('browser-sync'),
    sourcemaps = require('gulp-sourcemaps'),
    source = require('vinyl-source-stream'),
    buffer = require('vinyl-buffer'),
    concat = require('gulp-concat'),
    browserify = require('browserify'),
    uglify = require('gulp-uglify');

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
var sassOptions = {
    errLogToConsole: true,
    outputStyle: 'compressed'
};

gulp.task('scss', function() {
    gulp.src('./src/assets/sass/style.scss')
        .pipe(sourcemaps.init())
        .pipe(sass(sassOptions)).on('error', sass.logError)
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('./public/css'))
        .pipe(browserSync.reload({
            stream: true
        }))
});

gulp.task('browserify', function() {
    return browserify('src/assets/js/app.js')
        .bundle()
        .pipe(source('main.js'))
        .pipe(buffer()) // <----- convert from streaming to buffered vinyl file object
        .pipe(uglify()) // now gulp-uglify works
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
gulp.task('watch', ['browserSync', 'scss'], function(){
    gulp.watch('src/assets/sass/**/*.scss', ['scss']);
    gulp.watch('src/assets/js/**/*.*', ['browserify']);
    gulp.watch(['public/*.php','public/templates/*.html', 'app/**/*.php'], browserSync.reload);
    gulp.watch('public/js/*.js', browserSync.reload);
});

// Default task
gulp.task('default', ['scss', 'copy', 'browserify']);
