'use strict';

// require('babel-polyfill');
import React from 'react';
import ReactDom from 'react-dom';
import ReactDomServer from 'react-dom/server';
import Cart from './Cart'

if (!global) {
  global = {};
}
global.React = React;
global.ReactDom = ReactDom;
global.ReactDomServer = ReactDomServer;
global.App = App;