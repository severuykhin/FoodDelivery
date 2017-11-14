"use strict";

const { params,  plugins : $ } = require("./variables");

module.exports = () =>
    $.gulp.src(params.fonts)
        .pipe($.gulp.dest(params.out + '/images/fonts'))
        .pipe($.gulp.dest(params.prod + '/images/fonts'))
        .pipe($.gulp.dest(params.web + '/images/fonts'))