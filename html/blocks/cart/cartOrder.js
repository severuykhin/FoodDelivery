export default function initCartOrder() {
    if ($('[data-role="cart-order"]').length <= 0) return false;

    $('[data-role="cart-order-dom"]').on('click', function () {
        $(this).prev().find('input').val('Домофон');
    });
}