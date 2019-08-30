import {createStore, applyMiddleware} from 'redux';
import logger from 'redux-logger';
import thunk from 'redux-thunk';
import reducer, { browserRouterMiddleware } from './reducer';
import createSagaMiddleWare from 'redux-saga';

import rootSaga from './saga/rootSaga';

const sagaMiddleware = createSagaMiddleWare();
const store = createStore(reducer, applyMiddleware(thunk, logger,  browserRouterMiddleware, sagaMiddleware));

sagaMiddleware.run(rootSaga);

if (process.env.NODE_ENV === 'development') {
    const socket = new WebSocket('ws://localhost:1234');
    
    const heartBeat = () => {
        socket.send('Heartbeat');
    };
    
    socket.onopen = function (e) {
        console.log('Message connection ready');
        setInterval(heartBeat, 3000);
    }
}


export default store;

window.store = store;