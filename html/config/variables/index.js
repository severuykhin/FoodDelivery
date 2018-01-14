"use strict";

const { bs, reload } = require("../browserSync");

module.exports = {
    params : {
        out: "public",
        prod: "public/prod",
        web : "../site/web/statics",
        htmlSrc: [
            "pug/index.pug",
            "pug/contacts.pug",
            "pug/category.pug",
            "pug/menu.pug",
            "pug/about.pug"
        ],
        levels: ["xs", "sm", "md", "lg", "xl"],
        html: ["pug/*.pug", "blocks/**/*.pug"],
        blocksName : [
            "header",
            "footer",
            "content",
            "logo",
            "menu",
            "contacts",
            "contact",
            "map",
            "grid",
            "actions",
            "best",
            "dish",
            "button",
            "about",
            "adv",
            "app",
            "modal",
            "overlay",
            "social",
            "reviews",
            "zoompic",
            "store",
            "filter",
            "app",
            "headline",
            "vkgroup",
            "banners",
            "feed",
            "photo",
            "photoblock",
        ],
        js: ['../node_modules/slick-carousel/slick/slick.min.js'],
        json: "blocks/**/*.json",
        css: [],
        sass: [
            "setting.block/bootstrap.scss",
            "setting.block/custom.scss"
        ],
        images: [],
        fonts : 'fonts/**/*',
        type: {
            css   : "blocks/**/**/*.css",
            sass  : "blocks/**/**/*.scss",
            js    : "blocks/**/**/*.js",
            images: "blocks/**/**/*.{gif,jpg,jpeg,png,ico,svg}"
        }
    },
    plugins: {
        gulp         : require("gulp"),
        concat       : require("gulp-concat"),
        rename       : require("gulp-rename"),
        path         : require("path"),
        url          : require("gulp-css-url-adjuster"),
        autoprefixer : require("autoprefixer"),
        postcss      : require("gulp-postcss"),
        pug          : require("gulp-pug"),
        babel        : require("gulp-babel"),
        jshint       : require("gulp-jshint"),
        plumber      : require("gulp-plumber"),
        uglify       : require("gulp-uglify"),
        sass         : require("gulp-sass"),
        fs           : require("fs"),
        clean        : require("gulp-clean"),
        replace      : require("gulp-replace"),
        merge        : require("gulp-merge-json"),
        htmlmin      : require("gulp-htmlmin"),
        csso         : require("postcss-csso"),
        bs           : bs,
        reload       : reload
    }
};