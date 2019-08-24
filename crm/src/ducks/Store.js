
export const MODULE_NAME = 'store';
export const SET_ORDERS  = `${MODULE_NAME}/SET_ORDERS`;
export const SET_ORDERS_QUERY  = `${MODULE_NAME}/SET_ORDERS_QUERY`;
export const SET_CUSTOMERS  = `${MODULE_NAME}/SET_CUSTOMERS`;
export const SET_PRODUCTS  = `${MODULE_NAME}/SET_PRODUCTS`;
export const PUT_PRODUCT_CROSS_SELL  = `${MODULE_NAME}/PUT_PRODUCT_CROSS_SELL`;
export const GET_PRODUCT_CROSS_SELL  = `${MODULE_NAME}/GET_PRODUCT_CROSS_SELL`;
export const TOGGLE_MODAL = `${MODULE_NAME}/TOGGLE_MODAL`;
export const GET_ORDER_MAP = `${MODULE_NAME}/GET_ORDER_MAP`;
export const PUT_ORDER_MAP = `${MODULE_NAME}/PUT_ORDER_MAP`;

const InitialState = {
	ordersSummary: {},
	customerSummary: [],
	productsSummary: [],
	productsCrossSell: {},
	modalOpen: false,
	ordersQuery: {},
	orderMap: {},
	isOrderMapPending: false
};

export default function storeReducer(state = InitialState, action) {

	const {type, payload} = action;

	let newState = {...state};

	switch(type) {
		case SET_ORDERS:
			newState = Object.assign({}, state);
			newState.ordersSummary = payload;
			return newState;
		case SET_ORDERS_QUERY:
				newState.ordersQuery = payload;
				return newState;
		case SET_CUSTOMERS:
			newState = Object.assign({}, state);
			newState.customerSummary = payload;
			return newState;
		case SET_PRODUCTS:
			newState = Object.assign({}, state);
			newState.productsSummary = payload;
			return newState;
		case TOGGLE_MODAL:
			return Object.assign({}, state, {modalOpen: payload});

		case PUT_PRODUCT_CROSS_SELL:
			newState.productsCrossSell[payload.id] = payload.data;
			return newState;

		case GET_ORDER_MAP:
			newState.isOrderMapPending = true;
			return newState;

		case PUT_ORDER_MAP:
			newState.orderMap = payload;
			newState.isOrderMapPending = false;
			return newState;

		default:
			return state;
	}
};

export const setOrders = (orders) => {
	return {
		type: SET_ORDERS,
		payload: orders 
	};
}

export const setCustomers = (customerSummary) => {
	return {
		type: SET_CUSTOMERS,
		payload: customerSummary 
	};
}

export const setProducts = (productsSummary) => {
	return {
		type: SET_PRODUCTS,
		payload: productsSummary 
	};
}

export const setOrdersQuery = (queryData) => {
	return {
		type: SET_ORDERS_QUERY,
		payload: queryData 
	};
}

export const toggleModal = (isOpen) => {
	return {
		type: TOGGLE_MODAL,
		payload: isOpen
	};
}

export const getProductCrossSell = (productId) => ({
	type: GET_PRODUCT_CROSS_SELL,
	payload: productId
});

export const getOrderMap = (requesData) => ({
	type: GET_ORDER_MAP,
	payload: requesData
});

/**
 * @param {object} data - Order map data 
 */
export const putOrderMap = (data) => ({
	type: PUT_ORDER_MAP,
	payload: data
});