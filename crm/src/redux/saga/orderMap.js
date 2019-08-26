import { 
    GET_ORDER_MAP, 
    putOrderMap 
} from '../../ducks/Store'

import { 
    takeLatest, 
    put 
} from 'redux-saga/effects'

import config from '../../config';

import axios from 'axios';

function* getOrderMapAsync(action) {

    const { payload } = action;

    try {

        const response = yield axios.get(config.orderMapUrl, {
            params: payload
        });

        if (response.status === 200) {
            yield put(putOrderMap(response.data))
        } else {
            // Process some errors if exists
        }

    } catch(e) {
        console.log(e);
        // Process some errors if exists
    }


}

export function* watchGetOrderMap() {
    yield takeLatest(GET_ORDER_MAP, getOrderMapAsync);
}