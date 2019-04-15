<?php

use yii\helpers\Url;

?>

<div class="cart-widget">
    <div class="cart-widget__summ">
        <span class="cart-widget__money" data-role="cart-widget-summ">0</span>
        ₽
    </div>
    <div class="cart-widget__dropdown" id="cart-widget-dropdown">
        <div class="cart-widget__top">
            Минимальная сумма заказа - 450 руб.
        </div>
        <div data-role="cart-widget" class="cart-widget__list">

        </div>
        <div class="cart-widget__bottom">
            <a 
                data-role="cart-widget-order-button"
                href="<?= Url::to(['cart/index']); ?>" 
                class="button button__primary" 
                title="Оформить заказ">Заказать</a>
            <span class="cart-widget__summ-bottom">
                <span class="cart-widget__money-bottom" data-role="cart-widget-summ-bottom">0</span>
                ₽
            </span>
        </div>
    </div>
    <a title="Сделать заказ" class="cart-widget__link" href="<?= Url::to(['cart/index']); ?>">
        <span class="cart-widget__counter" data-role="cart-counter">0</span>
    </a>
</div>