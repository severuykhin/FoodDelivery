export default function summTemplate(summ) {
    return `
    <div class="cart-page__row cart-page__row_nopadding">
        <div class="cart-page__total">Сумма заказа: <span class="cart-page__totalPrice">${summ} руб.</span></div>
    </div>
    `;
}