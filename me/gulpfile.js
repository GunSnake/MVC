var gulp = require('gulp');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var minifycss = require('gulp-minify-css');
var concat = require('gulp-concat');
var order = require("gulp-order");


gulp.task('mainCss', function () {
    gulp.src(['css/normalize.css',
        'css/yue.css',
        'css/style.css',
        'css/font-awesome.min.css',
        'bower/components/bootstrap/dist/css/bootstrap.min.css',
        'bower/components/ng-notify/dist/ng-notify.min.css'])
        .pipe(concat('app.css'))
        .pipe(gulp.dest('dist/css'))
        .pipe(minifycss())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('dist/css'))
});

gulp.task('mainScript', function () {
    gulp.src(['bower/components/jquery/dist/jquery.js',
        'bower/components/angular/angular.min.js',
        'bower/components/angular-route/angular-route.min.js',
        'bower/components/angular-sanitize/angular-sanitize.min.js',
        'bower/components/showdown/compressed/showdown.js',
        'bower/components/ng-notify/dist/ng-notify.min.js',
        'js/wizMarkdown.min.js',
        'js/jspdf.min.js',
        'js/jspdf.plugin.addhtml.js',
        'bower/components/angular-cookies/angular-cookies.min.js',
        'bower/components/angularLocalStorage/src/angularLocalStorage.js',
        'js/app.js'
    ])
        .pipe(concat('app.js'))
        .pipe(gulp.dest('dist/js'))
        .pipe(uglify())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('dist/js'))
});


gulp.task('default', ['mainCss', 'mainScript']);

