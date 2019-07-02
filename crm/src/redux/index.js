import {createStore, applyMiddleware} from 'redux';
import logger from 'redux-logger';
import thunk from 'redux-thunk';
import reducer, { browserRouterMiddleware } from './reducer';

const store = createStore(reducer, applyMiddleware(logger, thunk, browserRouterMiddleware));
export default store;

window.store = store;