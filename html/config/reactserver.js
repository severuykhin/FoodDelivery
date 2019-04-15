"use strict";

const { params }     = require("./variables/index");
const gulp           = require("gulp");
const webpackServerConfig  = require("../webpack.reactserver.js");
const webpackGulp    = require("webpack-stream");
const webpack        = require("webpack");
const browserSync    = require("browser-sync");
const plumber        = require("gulp-plumber");


module.exports = () =>
    gulp.src("react/server.js")
        .pipe(plumber())
        .pipe(webpackGulp(webpackServerConfig, webpack))
        .pipe(gulp.dest(params.out))        
        .pipe(gulp.dest(params.prod))        
        .pipe(gulp.dest(params.web))
        .pipe(browserSync.reload({ stream: true }));