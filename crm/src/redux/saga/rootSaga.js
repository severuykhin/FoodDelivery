import { put, takeEvery, all } from 'redux-saga/effects'
import { watchGetCrossSell } from './crossSell';
import { watchGetOrderMap } from './orderMap';

export default function* init() {
    yield all([
        watchGetCrossSell(),
        watchGetOrderMap()
    ]);
}