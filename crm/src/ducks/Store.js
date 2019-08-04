
export const MODULE_NAME = 'store';
export const SET_ORDERS  = `${MODULE_NAME}/SET_ORDERS`;
export const SET_ORDERS_QUERY  = `${MODULE_NAME}/SET_ORDERS_QUERY`;
export const SET_CUSTOMERS  = `${MODULE_NAME}/SET_CUSTOMERS`;
export const SET_PRODUCTS  = `${MODULE_NAME}/SET_PRODUCTS`;
export const TOGGLE_MODAL = `${MODULE_NAME}/TOGGLE_MODAL`;

const InitialState = {
	ordersSummary: {},
	customerSummary: [],
	productsSummary: [],
	modalOpen: false,
	ordersQuery: {}
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