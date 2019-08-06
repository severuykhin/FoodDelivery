const path = require('path');
const webpack = require('webpack');
const Uglify = require('uglifyjs-webpack-plugin');

let MODE = process.argv[process.argv.length - 1].substr(1) === 'prod' ? 'production' : 'development';

const config = {
    entry  : path.resolve(__dirname, './react/index.js'),
    mode   : MODE,
    output : {
      filename: 'modules.bundle.js',
      path: path.resolve(__dirname, '/public')
    },
    module: {

      rules: [
        {
        test: /\.(js|jsx)$/,
        loader: 'babel-loader',
        exclude: /node_modules/,
          query: {
            presets: ['es2015', 'react'],
            "plugins": [
              "transform-object-rest-spread",
              "transform-class-properties"
            ]
          }
        }
      ]
    }
};

module.exports = config;