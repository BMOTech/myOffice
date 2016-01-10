var gulp = require('gulp'),
    sass = require('gulp-sass'),
    browserSync = require('browser-sync'),
    sourcemaps = require('gulp-sourcemaps'),
    browserify = require('browserify'),
    source = require('vinyl-source-stream'),
    buffer = require('vinyl-buffer');

// Icons
gulp.task('icons', function() {
    gulp.src('./node_modules/font-awesome/fonts/**.*')
        .pipe(gulp.dest('./public/fonts'));
    gulp.src('./node_modules/bootstrap-sass/assets/fonts/**/**.*')
        .pipe(gulp.dest('./public/fonts'));
});

// CSS
gulp.task('scss', function() {
    gulp.src('./src/assets/sass/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass()).on('error', sass.logError)
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('./public/css'))
        .pipe(browserSync.reload({
            stream: true
        }))
});

// Vue
gulp.task('vue', function() {
    var bundleStream = browserify('./src/assets/vue/app.js').bundle()
    bundleStream
        .pipe(source('bundle.js'))
        .pipe(buffer())
        .pipe(sourcemaps.init({ loadMaps: true }))
        .on('error', function (err) {
            console.log(err.toString());
            this.emit("end");
        })
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('./public/js'))
});

// BrowserSync
gulp.task('browserSync', function() {
    browserSync({
        proxy: {
            target: "webtechniken.app"
        }
    })
});

// Rerun the task when a file changes
gulp.task('watch', ['browserSync', 'scss', 'vue'], function(){
    gulp.watch('src/assets/sass/**/*.scss', ['scss']);
    gulp.watch('src/assets/vue/**/*.*', ['vue']);
    gulp.watch('public/*.php', browserSync.reload);
    gulp.watch('public/js/*.js', browserSync.reload);
});

// Default task
gulp.task('default', ['icons', 'scss', 'vue']);
