// REQUIRED SETTINGS
var siteUrl = 'example.dev';

// Include gulp
var gulp = require('gulp');

// pull in the plugins
$ = require('gulp-load-plugins')({
            pattern: [
                'gulp-*',
                'browser-sync',
                'main-bower-files'
            ]
});

// browser-sync task for starting the server.
gulp.task('browser-sync', function() {
    $.browserSync({
        proxy: siteUrl
    });
});

// task for reloading the browser
gulp.task('bs-reload', function() {
    $.browserSync.reload();
});

// Lint Javascript Task
gulp.task('lint', function() {
    return gulp.src('assets/js/*.js')
        .pipe($.jshint())
        .pipe($.jshint.reporter('jshint-stylish'));
});

// compile, prefix, and minify the sass
gulp.task('styles', function() {
    return $.rubySass('assets/scss/style.scss')
        .on('error', function (err) {
            console.error('Error! ' + err.message);
        })
        .pipe($.using())
        .pipe($.autoprefixer(["> 1%", "last 2 versions", "Firefox ESR", "Opera 12.1" , "ie 7"], { cascade: true }))
        .pipe(gulp.dest('.'))
        .pipe($.rename({suffix: '.min'}))
        .pipe($.minifyCss())
        .pipe(gulp.dest('.'))
        .pipe($.browserSync.reload({stream:true}));
});

// Concatenate & Minify JS
gulp.task('scripts', function() {
    return gulp.src('assets/js/*.js')
        .pipe($.plumber())
        .pipe($.sourcemaps.init())
            .pipe($.concat('all.min.js'))
            .pipe($.uglify())
        .pipe($.sourcemaps.write('../maps'))
        .pipe(gulp.dest('assets/js/dist'))
        .pipe($.browserSync.reload({stream:true}));
});

// Concatenate and Minify Vendor JS and CSS
gulp.task('vendors', function() {
    var jsFilter   = $.filter('*.js');
    var cssFilter  = $.filter('*.css');
    var fontFilter = $.filter(['*.otf', '*.eot', '*.svg', '*.ttf', '*.woff']);

    return gulp.src($.mainBowerFiles())
        .pipe($.plumber())
        .pipe(jsFilter)
        .pipe($.using())
        .pipe($.sourcemaps.init())
            .pipe($.concat('vendor.min.js'))
            .pipe($.uglify())
        .pipe($.sourcemaps.write('../maps'))
        .pipe(gulp.dest('assets/js/dist'))
        .pipe(jsFilter.restore())
        .pipe(cssFilter)
        .pipe($.using())
        .pipe($.concat('vendor.min.css'))
        .pipe($.minifyCss())
        .pipe(gulp.dest('.'))
        .pipe(cssFilter.restore())
        .pipe(fontFilter)
        .pipe($.using())
        .pipe(gulp.dest('assets/fonts'))
        .pipe(fontFilter.restore());
});

// Watch Files For Changes
gulp.task('watch', function() {
    gulp.watch('assets/js/*.js', ['lint', 'scripts']);
    gulp.watch('assets/scss/**/*.scss', ['styles']);
    gulp.watch('**/*.html', ['bs-reload']);
    gulp.watch('**/*.php', ['bs-reload']);
});

// Default Task
gulp.task('default', ['lint', 'styles', 'vendors', 'scripts', 'watch']);

// run some setup tasks. only called if user runs gulp setup
gulp.task('setup', function() {
    return $.bower();
});
