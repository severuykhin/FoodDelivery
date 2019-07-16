/**
 * @param { number } priceValue
 * @returns { string } Price formatted as decimal
 */
export default priceValue => {
    return parseInt(priceValue).toString().replace(/(\d{1,3}(?=(\d{3})+(?:\.\d|\b)))/g, "\$1 ");
}