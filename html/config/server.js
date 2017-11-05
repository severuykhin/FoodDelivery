"use strict";

const { params, plugins: $ } = require("./variables");

module.exports = function () {

    $.bs.init({
        server: $.path.resolve(params.out)
    });

    $.gulp.watch(params.html, ["htmlReload"]);
    $.gulp.watch([params.type.sass, "./setting.block/*.scss"], ["css"]);
    $.gulp.watch(params.type.images, ["images"]);
    $.gulp.watch(params.type.js, ["js"]);
};