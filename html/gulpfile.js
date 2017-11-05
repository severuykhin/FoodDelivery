"use strict";

const { plugins: { gulp } } = require("./config/variables");

const createTask = function (taskName, beforeTasks) {
    if ( !beforeTasks ) return gulp.task( taskName, require(`./config/${taskName}`) );

    return gulp.task( taskName, beforeTasks, require(`./config/${taskName}`) );
};

const tasks = [
    [ "server" ],
    [ "json-clean" ],
    [ "json", ["json-clean"] ],
    [ "html", ["json"] ],
    [ "htmlReload", ["html"] ],
    [ "preCss" ],
    [ "css", ["preCss"] ],
    [ "images" ],
    [ "js" ],
    [ "jquery" ],
    [ "createFirstLevelBlocks" ],
    [ "createBlocks" ]
];

gulp.task("default", ["server", "build"]);

gulp.task("build", ["html", "css", "images", "js", "jquery"]);

for( let taskName of tasks ) {
    createTask(...taskName);
}