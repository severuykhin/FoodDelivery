export default function rawTemplate(item) {

    let summ = item.price * item.quantity,
        size = item.size ? `<div class="cart-page__mod">${ item.size }</div>` : '',
        disabled = item.quantity <= 1 ? 'disabled' : ''

    return `

    <div class="cart-page__row">
        <div class="cart-page__img">
            <img src="${item.pic}">
        </div>
        <div class="cart-page__title">
            <div class="cart-page__name">${item.title}</div>
            ${size}
        </div>
        <div class="cart-page__count">
            <div class="dish__regulator dish__regulator_widget active" data-role="dish-regulator">
                <button 
                    ${disabled}
                    class="button button_regulator button_minus" 
                    data-id="${item.id}"
                    data-mId="${item.mId}" 
                    data-role="product-decrease">-
                </button>
                <span class="dish__amount" data-role="dish-amount">${item.quantity}</span>
                <button 
                    class="button button_regulator button_plus" 
                    data-id="${item.id}"
                    data-mId="${item.mId}"
                    data-role="product-increase">+
                </button>
            </div>
        </div>
        <div class="cart-page__price"> ${summ} ₽ </div>
        <div class="cart-page__remove">
            <button
                data-id="${item.id}"
                data-mid="${item.mId}" 
                class="cart-widget__delete" 
                data-role="cart-widget-delete">&times;</button>
        </div>
    </div>
    
    `;
}