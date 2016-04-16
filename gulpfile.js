var browserslist, include, less, minifyCSS, uglify, autoprefix, postcss, mqpacker, logWarnings;
var browsers     = {
    browsers: '> 1%, last 2 versions, IE >= 8, Firefox ESR, Opera 12.1',
    remove: false
};
var config       = require('./gulpconfig.json');
var gulp         = require('gulp');
var rename       = require('gulp-rename');
var plumber      = require('gulp-plumber');
var gutil        = require('gulp-util');

function loadJSModules() {
    include = require('gulp-include');
    uglify = require('gulp-uglify');
}

function loadLessModules() {
    browserslist = require('browserslist');
    less = require('gulp-less');
    minifyCSS = require('gulp-minify-css');
    postcss = require('gulp-postcss');
    autoprefix = require('autoprefixer');
    mqpacker = require('css-mqpacker');
    logWarnings = require('postcss-log-warnings');
}

function logStartMsg(name, target) {
    gutil.log("Starting '" + gutil.colors.cyan(name + "::" + target) + "'...");
}

function logEndMsg(name, target, timeStart, timeEnd) {
    gutil.log("Finished '" + gutil.colors.cyan(name + "::" + target) + "' after " + gutil.colors.magenta((timeEnd - timeStart) + " ms"));
}

function getFilenameByPath(path) {
   return path.split(/[\\/]/).pop();
}

function getDirectoryByPath(path) {
    parts = path.split(/[\\/]/);
    parts.pop();

    return parts.join('/');
}

function getTarget() {
    target = 'default';
    arguments = process.argv;
    arguments.forEach(function(value, index, array){
        if (value.indexOf('--target=') > -1) {
            target = value.replace('--target=', '');
        }
    });

    return target;
}

function compileLESS(target) {
    var timeStart, timeEnd;
    timeStart = new Date();
    logStartMsg('less', target);
    for(src in config.less[target].files) {
        dest = config.less[target].files[src];
        if (dest.constructor !== Array)
            dest = Array(dest);
        dest.forEach(function(destination){
            if (getFilenameByPath(destination).indexOf('.min.') > -1) {
                gulp.src(src)
                    .pipe(plumber(function(error) {
                        gutil.log(gutil.colors.red('Error: ' + error.message));
                        this.emit('end');
                    }))
                    .pipe(less())
                    .pipe(postcss(
                        [
                            mqpacker({sort: true}),
                            autoprefix(browsers),
                            logWarnings()
                        ]
                    ))
                    .pipe(minifyCSS({
                        keepSpecialComments: false
                    }))
                    .pipe(rename(getFilenameByPath(destination)))
                    .pipe(gulp.dest(getDirectoryByPath(destination)))
                ;
            } else {
                gulp.src(src)
                    .pipe(plumber(function(error) {
                        gutil.log(gutil.colors.red('Error: ' + error.message));
                        this.emit('end');
                    }))
                    .pipe(less())
                    .pipe(postcss(
                        [
                            mqpacker({sort: true}),
                            autoprefix(browsers),
                            logWarnings()
                        ]
                    ))
                    .pipe(rename(getFilenameByPath(destination)))
                    .pipe(gulp.dest(getDirectoryByPath(destination)))
                ;
            }
        });
    }
    timeEnd = new Date();
    logEndMsg('less', target, timeStart, timeEnd);
}

function compileJS(target) {
    var timeStart, timeEnd;
    timeStart = new Date();
    logStartMsg('js', target);
    for(src in config.js[target].files) {
        dest = config.js[target].files[src];
        if (dest.constructor !== Array)
            dest = Array(dest);
        dest.forEach(function(destination){
            if (getFilenameByPath(destination).indexOf('.min.') > -1) {
                gulp.src(src)
                    .pipe(plumber(function(error) {
                        gutil.log(gutil.colors.red('Error: ' + error.message));
                        this.emit('end');
                    }))
                    .pipe(include())
                    .pipe(uglify())
                    .pipe(rename(getFilenameByPath(destination)))
                    .pipe(gulp.dest(getDirectoryByPath(destination)))
                ;
            } else {
                gulp.src(src)
                    .pipe(plumber(function(error) {
                        gutil.log(gutil.colors.red('Error: ' + error.message));
                        this.emit('end');
                    }))
                    .pipe(include())
                    .pipe(rename(getFilenameByPath(destination)))
                    .pipe(gulp.dest(getDirectoryByPath(destination)))
                ;
            }
        });
    }
    timeEnd = new Date();
    logEndMsg('js', target, timeStart, timeEnd);
}

gulp.task('js', function(){
    loadJSModules();
    compileJS(getTarget())
});

gulp.task('less', function(){
    loadLessModules();
    compileLESS(getTarget());
});

gulp.task('watch', function () {
    loadJSModules();
    loadLessModules();
    config.watch.forEach(function(o){
        var observed = o;
        gulp.watch(observed.files, function(){
            observed.run.forEach(function(task){
                if (task == 'less') {
                    compileLESS(observed.target);
                } else if ( task == 'js') {
                    compileJS(observed.target);
                }
            });
        });
    });
});

gulp.task('default', function() {
    var p;
    var spawn = require('child_process').spawn;
    var spawnChildren = function(e) {
        if (p) { p.kill(); }
        p = spawn('npm', ['run', 'gulp:watch'], {stdio: 'inherit'});
    }
    gulp.watch('gulpconfig.json', spawnChildren);
    spawnChildren();
});