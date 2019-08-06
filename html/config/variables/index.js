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
        js: [
            '../site/vendor/yiisoft/yii2/assets/yii.js',
            '../site/vendor/yiisoft/yii2/assets/yii.validation.js',
            '../site/vendor/yiisoft/yii2/assets/yii.activeForm.js',
            'node_modules/slick-carousel/slick/slick.min.js',
            'node_modules/simplebar/dist/simplebar.min.js',
            'node_modules/inputmask/dist/inputmask/inputmask.js'
        ],
        json: "blocks/**/*.json",
        css: [],
        sass: [
            "setting.block/bootstrap.scss",
            "setting.block/custom.scss",
            "node_modules/simplebar/dist/simplebar.min.css",
            "node_modules/@glidejs/glide/dist/css/glide.core.min.css",
            "node_modules/@glidejs/glide/dist/css/glide.theme.min.css"
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
        reload       : reload,
        webpack       : require("webpack"),
        webpackConfig : require("../../webpack.config"),
        webpackGulp   : require("webpack-stream")
    }
};