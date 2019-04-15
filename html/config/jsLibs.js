"use strict";

const { params,  plugins : $ } = require("./variables");

console.log(params.js);

module.exports = () =>
    $.gulp.src(params.js)
        .pipe($.concat({
            path: 'libs.js'
        }))
        .pipe($.gulp.dest(params.out))
        .pipe($.replace(/("use\sstrict";\s+)?\$\(function\s\(\)\s\{\}\);/g, ""))
        .pipe($.uglify())
        .pipe($.gulp.dest(params.prod))
        .pipe($.gulp.dest(params.web));