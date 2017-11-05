$(function () {

var Dish = (function (d, w) {

    const roleOrder   = 'dish-order';
    const roleOverlay = 'overlay';

    return {
        showDishModal             : function (template) {
            App.showModal('ПРивет');
        },

        closeDishModal            : function () {
            App.removeModal();
        },

        registerHandlers : function () {

            const obj = this;

            d.addEventListener('click', function (e) {
                console.log();
                let target = e.target.getAttribute('data-role');

                if (target === roleOrder) {
                    obj.showDishModal();
                } else if (target === roleOverlay) {
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