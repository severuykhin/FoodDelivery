import {createStore, applyMiddleware} from 'redux';
import logger from 'redux-logger';
import thunk from 'redux-thunk';
import reducer, { browserRouterMiddleware } from './reducer';
import createSagaMiddleWare from 'redux-saga';

import rootSaga from './saga/rootSaga';

const sagaMiddleware = createSagaMiddleWare();
const store = createStore(reducer, applyMiddleware(thunk, logger,  browserRouterMiddleware, sagaMiddleware));

sagaMiddleware.run(rootSaga);

export default store;

window.store = store;