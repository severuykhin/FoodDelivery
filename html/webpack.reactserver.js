const path = require('path');
const webpack = require('webpack');
const Uglify = require('uglifyjs-webpack-plugin');

const config = {
    entry  : path.resolve(__dirname, './react/server.js'),
    mode   : 'production',
    output : {
      filename: 'server.bundle.js',
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