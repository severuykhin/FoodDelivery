import { combineReducers } from 'redux';
import { createBrowserHistory } from 'history';
import { routerReducer as router,
		 routerMiddleware } from "react-router-redux";

import storeReducer, {MODULE_NAME as storeModule} from '../ducks/Store';
import reportsReducer, {MODULE_NAME as reportsModule} from '../ducks/Reports';

export const history = createBrowserHistory();
export const browserRouterMiddleware = routerMiddleware(history);

export default combineReducers({
	router,
	[storeModule] : storeReducer,
	[reportsModule] : reportsReducer,
});