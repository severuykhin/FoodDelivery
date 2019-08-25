export const getRegularCustomerReport = (store) => {

    if ( typeof store.store.customerSummary === 'undefined' ||
         store.store.customerSummary.length <= 0 ) {
            return null;
    }
    
    let totalCount = store. store.customerSummary.length;
    let regularCustomersCount = store.store.customerSummary.reduce((value, customer, index) => {
        return customer.orders.length >= 2 ? ++value : value;
    }, 0);

    let percentage = Math.floor(regularCustomersCount / (totalCount / 100));

    return {
        totalCount,
        regularCustomersCount,
        percentage
    };
}