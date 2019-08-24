import { SOUS_CATEGORY_ID } from './cart';

export default function widgetItemTemplate(config, isFree) {

    let summ = config.price * config.quantity,
        size = config.size ? `<div class="cart-widget__row-item cart-widget__row-middle">${ config.size }</div>` : '',
        disabled = config.quantity <= 1 ? 'disabled' : '';

    if (config.category_id == 20) {
        return `
            <div class="cart-widget__row">
                <div class="cart-widget__row-item cart-widget__row-top">
                    <div class="cart-widget__row-title"> Соус «${ config.title }»‎ </div>
                    <button 
                        data-role="cart-widget-delete"
                        data-id="${config.id}"
                        data-mid="${config.mId}"
                        class="cart-widget__delete">×</button>
                </div>
                ${ size }
                <div class="cart-widget__row-item cart-widget__row-bottom">
                    <div class="dish__regulator dish__regulator_widget active" data-role="dish-regulator">
                        <button 
                            ${disabled}
                            class="button button_regulator button_minus" 
                            data-id="${config.id}"
                            data-mId="${config.mId}" 
                            data-role="product-decrease">-
                        </button>
                        <span class="dish__amount" data-role="dish-amount">${ config.quantity }</span>
                        <button 
                            class="button button_regulator button_plus" 
                            data-id="${config.id}"
                            data-mId="${config.mId}" 
                            data-role="product-increase">+
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    return `
        <div class="cart-widget__row">
            <div class="cart-widget__row-item cart-widget__row-top">
                <div class="cart-widget__row-title"> ${ config.title } </div>
                <button 
                    data-role="cart-widget-delete"
                    data-id="${config.id}"
                    data-mid="${config.mId}"
                    class="cart-widget__delete">×</button>
            </div>
            ${ size }
            <div class="cart-widget__row-item cart-widget__row-bottom">
                <div class="dish__regulator dish__regulator_widget active" data-role="dish-regulator">
                    <button 
                        ${disabled}
                        class="button button_regulator button_minus" 
                        data-id="${config.id}"
                        data-mId="${config.mId}" 
                        data-role="product-decrease">-
                    </button>
                    <span class="dish__amount" data-role="dish-amount">${ config.quantity }</span>
                    <button 
                        class="button button_regulator button_plus" 
                        data-id="${config.id}"
                        data-mId="${config.mId}" 
                        data-role="product-increase">+
                    </button>
                </div>

                <div class="cart-widget__summ">
                    <span class="cart-widget__money" data-role="cart-widget-summ">${ summ + ' ₽' }</span>
                </div>
            </div>
        </div>
    `;
}