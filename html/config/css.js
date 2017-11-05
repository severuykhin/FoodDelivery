"use strict";

const { params, plugins: $ } = require("./variables");

const processors = [
    $.autoprefixer({browsers: ["last 4 version"]}),
    $.csso
];
params.sass.push(...( params.levels.map( (level) => `blocks/**/${level}/*.scss`) ) );


module.exports = () =>
    $.gulp.src("public/cache.scss")
        .pipe($.plumber())
        .pipe($.clean())
        .pipe($.sass.sync())
        .pipe($.url({
            replace:  ["../",""],
            prepend: "images/"
        }))
        .pipe($.postcss(processors))
        .pipe($.rename("styles.css"))
        .pipe($.gulp.dest(params.out))
        .pipe($.gulp.dest(params.prod))
        .pipe($.gulp.dest(params.web))
        .pipe($.reload({ stream: true }));