
export const getOrderMapSelector = (state) => {
    if (typeof state.store.orderMap !== 'undefined') {
        return {...state.store.orderMap};
    }
    return null;
}