"use strict";

const { params,  plugins : $ } = require("./variables");

let js = params.js.slice();
js.push(params.type.js);

module.exports = () =>
    $.gulp.src(js)
        .pipe($.plumber())
        .pipe($.jshint({
            esversion: 6
        }))
        .pipe($.jshint.reporter("jshint-stylish"))
        .pipe($.concat({
            path: 'main.js'
        }))
        .pipe($.babel({
            presets: ["latest", { compact: false }],
            babelrc: true,
            ignore: params.js
        }))
        .pipe($.gulp.dest(params.out))
        .pipe($.replace(/("use\sstrict";\s+)?\$\(function\s\(\)\s\{\}\);/g, ""))
        .pipe($.uglify())
        .pipe($.gulp.dest(params.prod))
        .pipe($.gulp.dest(params.web))
        .pipe($.reload({ stream: true }));