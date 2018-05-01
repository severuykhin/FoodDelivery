$(function () {

var Dish = (function (d, w) {

    const roleOrder   = 'dish-order';
    const roleOverlay = 'overlay';
    const roleClose   = 'modal-close';
    const tpl         = `<div class="dish__modal-tpl">
                            <div class="dish__modal-title">
                                В настоящее время заказ доставки возможен только по телефону
                            </div>
                            <a class="dish__modal-link" href="tel:+78332416646">+7-(8332)-41-66-46</a>
                        </div>`; 

    return {
        showDishModal             : function (template) {
            App.showModal(tpl);
        },

        closeDishModal            : function () {
            App.removeModal();
        },

        registerHandlers : function () {

            const obj = this;

            d.addEventListener('click', function (e) {
                
                let target = e.target.getAttribute('data-role');

                if (target === roleOrder) {
                    obj.showDishModal();
                    _.sendMetrika('dish_order');
                } else if (target === roleOverlay || target === roleClose) {
                    obj.closeDishModal();
                }
                
            });
        },

        init : function () {
            this.registerHandlers();   
        }
    };
})(document, window);

if (typeof Dish !== 'undefined') {
    Dish.init();
}

});