import { 
    GET_PRODUCT_CROSS_SELL, 
    PUT_PRODUCT_CROSS_SELL 
} from '../../ducks/Store'

import { 
    takeLatest, 
    put 
} from 'redux-saga/effects'

import axios from 'axios';
   
function* getProductCrossSellAsync(action) {
    let id = action.payload;
    
    let response = yield axios.get(`/backend/api/cross-sell?id=${id}`);

    yield put({
        type: PUT_PRODUCT_CROSS_SELL,
        payload: {
            id: id,
            data: response.data
        }
    });
    
}

export function* watchGetCrossSell () {
    yield takeLatest(GET_PRODUCT_CROSS_SELL, getProductCrossSellAsync);
}