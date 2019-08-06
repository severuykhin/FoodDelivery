/**
 * Точка входа в приложение
 */
import '@babel/polyfill';
import initActions from './actions/xs/actions';
import initFancy from './zoompic/xs/zoompic';
import initCartOrder from './cart/cartOrder';
import Header from './header/xs/header';
import App from './app/xs/app';
import Cart from './cart/cart';
import initMap from './map/xs/map';

const header = new Header();
header.init();

initActions();
initFancy();
initMap();
initCartOrder();

if ($('[data-phone]').length > 0) {

    let inputs = document.querySelectorAll('[data-phone]');

    for (var i = 0; i < inputs.length; i++) {
        let mask = new Inputmask("+7 (999) 999-99-99");
        let phoneInput = inputs[i];
        mask.mask(phoneInput);
    }
}

const cart = new Cart();

// Make cart actions as soon as posible
window.addEventListener('DOMContentLoaded', function () {
    cart.init();
});

// Lazyloading action only after window loaded
window.addEventListener('load', function () {
    App.lazyLoad.init();
    if (document.querySelector('[data-lazyload="true"]') !== null) {
        App.lazyLoad.init();
    }
});
