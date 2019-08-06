import widgetItemTemplate from './widgetTemplate';
import pageItemTemplate from './rawTemplate';
import mobileWidget from './mobileWidget';
import mountSouses from './cartSouses';

const SOUSES_CATEGORY_ID = 20;

class Cart {

    constructor() {

        this.modBtns = document.querySelectorAll('[data-role="modification-button"]');
        this.summ = document.querySelector('[data-role="cart-widget-summ"]');
        this.summBottom = document.querySelector('[data-role="cart-widget-summ-bottom"]');
        this.count = $('[data-role="cart-counter"]');
        this.widget = $('[data-role="cart-widget"]');
        this.cartPage = $('[data-role="cart-page"]');
        this.cartPageSummCount = $('[data-role="cart-page-summ-count"]');

        this.scrollBar = null;

        this.csrfParam = $('[name="csrf-param"]').attr('content');
        this.csrfContent = $('[name="csrf-token"]').attr('content');

        this.widgetOrderBtn = $('[data-role="cart-widget-order-button"]');

        this.form = $('[data-role="cart-order-form"]');
        this.orderStub = $('[data-role="cart-order-stub"]');

        this.state = {
            storage: [],
            bonuses: []
        };
    }

    init() {
        this.initHandlers();
        this.actualize();

        mountSouses();

        if ($(window).width() <= 990) {
            mobileWidget();
        }
    }

    actualize() {
        let initialState = window.initialData;

        if (typeof initialState === 'string') {
            try {
                initialState = JSON.parse(initialState);
            } catch(e) {
                initialState = [];
            }
        }

        console.log(initialState);

        this.state.storage = initialState.items;
        this.state.bonuses = initialState.bonuses;
        this.updateCards();
        this.update();
    }

    initHandlers() {
        this.initModificationsButtons();
        this.initAddButtons();
    }

    initModificationsButtons() {
        Array.prototype.slice.call(this.modBtns).forEach( btn => {
            btn.addEventListener('click', () => {
                this.switchModification(btn);
            });
        });
    }

    initAddButtons() {

        const addToCart = this.addToCart.bind(this);
        const removeFromCart = this.removeFromCart.bind(this);
        const increase = this.increase.bind(this);
        const decrease = this.decrease.bind(this);
        const deleteItem = this.deleteAll.bind(this);

        $(document).on('click', '[data-role="product-add"]', function () {
            addToCart($(this));
        });

        $(document).on('click', '[data-role="product-remove"]', function () {
            removeFromCart($(this));
        });

        $(document).on('click', '[data-role="product-increase"]', function () {
            increase($(this));
        });

        $(document).on('click', '[data-role="product-decrease"]', function () {
            decrease($(this));
        });

        $(document).on('click', '[data-role="cart-widget-delete"]', function () {
            deleteItem($(this));
        });
    }

    switchModification(btn) {
        let $btn = $(btn),
            product = $btn.attr('data-product'),
            productCard = $btn.parents('[data-role="product"]'),
            regulator = productCard.find('[data-role="dish-regulator"]'),
            initAddBtn = productCard.find('[data-role="product-add"]');

        try {
            product = JSON.parse(product);
        } catch(e) {
            throw e; // Some useful stuff if error
        }

        let itemIndex = this.findProductIndex(product);

        if (itemIndex < 0) {
            initAddBtn.removeClass('disabled');
            regulator.removeClass('active');
            setTimeout(() => {
                regulator.find('[data-role="dish-amount"]').text(0);
            }, 100);
        } else {
            initAddBtn.addClass('disabled');
            regulator.addClass('active');
            regulator.find('[data-role="dish-amount"]').text(this.state.storage[itemIndex].quantity);
        }

        $btn.siblings().removeClass('dish__modifications-item_active');
        $btn.addClass('dish__modifications-item_active');

        this.changeProductCard(productCard, product);
    }

    changeProductCard(card, data) {
        card.find('[data-role="product-weight"]').text(data.weight);
        card.find('[data-role="product-price"]').text(data.price);
        card.find('[data-role="product-add"]').attr('data-product', JSON.stringify(data));
        card.find('[data-role="product-remove"]').attr('data-product', JSON.stringify(data));
    }

    /**
     * Add product to cart
     * @param {HTMLElement} addButton 
     */
    addToCart(addButton) {

        let product = addButton.attr('data-product');        

        try {
            product = JSON.parse(product);
        } catch(e) {
            throw e; // Some useful stuff if error
        }

        let itemIndex = this.findProductIndex(product);

        let quantity;

        if (addButton.data('bonus') == true && this.bonusesAvailable() > 0) {
            this.addLCBonus(product);
        }

        // Если в корзине нет товаров или нет конкретного товара
        if (this.state.storage.length == 0 || itemIndex < 0) {
            product.quantity = 1;
            quantity = 1;
            this.state.storage.push(product);
        } else {
            this.state.storage[itemIndex].quantity++;
            quantity = this.state.storage[itemIndex].quantity;
        }
        
        this.resolveRegulator(addButton, quantity);

        this.send(product, 'add')
            .then((data) => { 
                this.update();
                this.reachGoal('cart_add');
            });   

    }

    addLCBonus(product) {
        let items = JSON.parse(localStorage.getItem('bonuses'));
        items.push(product);
        localStorage.setItem('bonuses', JSON.stringify(items));

    }

    removeLCBonus(product) {
        let items = JSON.parse(localStorage.getItem('bonuses'));
        let index;

        items.forEach((item, i) => {
            if (product.id == item.id) {
                index = i;
                return;
            }
        });

        if (index) {
            
        }

    }

    removeFromCart(removeButton) {
        let product = removeButton.attr('data-product');

        try {
            product = JSON.parse(product);
        } catch(e) {
            throw e; // Some useful stuff if error
        }

        let sousToPizza = this.countCategoryAmount(3) - this.countCategoryAmount(20);

        if (removeButton.data('bonus') == true 
            && sousToPizza <= 0) {
            this.removeLCBonus(product);              
        }

        let itemIndex = this.findProductIndex(product);
        let item = this.state.storage[itemIndex];

        if (!item) return false;

        item.quantity--;

        this.send(product, 'remove')
            .then((data) => { 
                let regulator = removeButton.parent();
                if (item.quantity === 0) {
                    this.deleteItem(itemIndex);
                    this.hideRegulator(regulator);
                } else {
                    regulator.find('[data-role="dish-amount"]').text(item.quantity);
                }
                this.update(); 
            });
    }

    /**
     * Shows product quantity regulator
     * @param {HTMLElement} addButton 
     */
    resolveRegulator(addButton, quantity) {

        // If this is Order button, not plus
        if (addButton.attr('data-type') === 'add-init') {

            let regulator = addButton.prev();
            addButton.addClass('disabled');
            regulator.addClass('active');
            regulator.find('[data-role="dish-amount"]').text(quantity);

        } else if (addButton.attr('data-type') === 'add-plus') {

            addButton.prev().text(quantity);

        }
    }   

    /**
     * Hide quantity regulator 
     * @param {Object} regulator 
     */
    hideRegulator(regulator) {
        regulator.removeClass('active');
        regulator.next().removeClass('disabled');
    }

    increase(item) {
        let id = item.data('id'), 
            mId = item.data('mid');
        this.send({id, mId}, 'add')
            .then((response) => {
                this.updateItem({id, mId}, response.data.quantity); 
                return response;               
            })
            .then((response) => {
                let quantity = response.data.quantity;
                this.update();
                this.updateCard({id, mId, quantity});
                this.reachGoal('cart_add');
            })
            .catch((e) => {
                alert('Возникла ошибка. Попробуйте позже.');
                console.log(e);
            });
    }

    decrease(item) {
        let id = item.data('id'), 
            mId = item.data('mid');

        this.send({id, mId}, 'remove')
            .then((response) => {
                this.updateItem({id, mId}, response.data.quantity);
                return response;
            })
            .then((response) => {
                let quantity = response.data.quantity;
                this.update();
                this.updateCard({id, mId, quantity});
            })
            .catch((e) => {
                alert('Возникла ошибка. Попробуйте позже.');
                console.log(e);
            });
    }

    deleteAll(item) {
        let id = item.data('id'), 
            mId = item.data('mid');

        let itemIndex = this.findProductIndex({id, mId});

        this.send({id, mId}, 'delete')
            .then((response) => {
                if (response.result === 'ok') {}
                this.deleteItem(itemIndex);
                this.update();
                this.updateCard({id, mId, quantity: 0});
            })
            .catch((e) => {
                alert(e);
            })
    }

    send(product, action) {

        const self = this;

        const data = {
            [this.csrfParam]: this.csrfContent,
            item : {
                product: product.id,
                modification: product.mId,
            }
        }

        return new Promise((resolve, reject) => {
            $.ajax({
                url: `/cart/${action}`,
                method: 'POST',
                data: data,
                success: function (response) {
                    resolve(response);
                },
                error: function () {
                    reject();
                }
    
            });
        });

    }

    deleteItem(index) {
        this.state.storage.splice(index, 1);
    }

    update() {

        let summ = this.countSumm();

        if (this.state.storage.length > 0) {
            this.summ.textContent = summ;
            this.summBottom.textContent = summ;
            this.count.text( this.countItems() );
            this.count.show();
            $('.cart-widget__bottom').show();
        } else {
            this.summ.textContent = 0;
            this.count.text(0);
            // this.count.hide();
            $('.cart-widget__bottom').hide();
        }

        if (this.state.storage.length <= 0) {
            this.widget.html('Добавьте что-нибудь из меню');
        } else {
            let html = '';
            Array.prototype.slice.call(this.state.storage).forEach(item => {
                if (item.category_id == SOUSES_CATEGORY_ID) return '';
                html += widgetItemTemplate(item);
            });
            this.widget.html(html);

        }

        if (summ >= 450) {
            this.widgetOrderBtn.removeClass('inactive');
            this.widgetOrderBtn.attr('style', '');

        } else {
            this.widgetOrderBtn.addClass('inactive');
            this.widgetOrderBtn.css({'pointer-events': 'none'});
        }

        if (this.cartPage.length > 0) {
            this.updatePage();
        }

        if ($(window).width() > 990) {
            this.applyCustomScroll();
        }

        console.log(this.state.storage);


    }

    updatePage() {

        let summ = this.countSumm();

        if (this.state.storage.length <= 0) {
            this.cartPage.html('Добавьте что-нибудь из меню');
            this.form.hide();
            return false;            
        }

        let html = '';

        Array.prototype.slice.call(this.state.storage).forEach(item => {
            if (item.category_id == SOUSES_CATEGORY_ID) return '';
            html += pageItemTemplate(item);
        });

        this.cartPage.html(html);
        this.cartPageSummCount.html(`${summ} руб.`);

        if (summ < 450) {
            this.form.hide();
            this.orderStub.show();
        } else {
            this.form.show();
            this.orderStub.hide();
        }
    }

    bonusesAvailable() {
        let pizzaCount = this.countCategoryAmount(3); // 3 - pizza category id
        let sousBonusCount = this.countBonusAmount();

        let availableSousBonuses = pizzaCount - sousBonusCount;

        return availableSousBonuses;
    }

    updateSousCount() {
        
        let sousBonusAmount = this.bonusesAvailable();
        let textValue = souseTextValue(sousBonusAmount);

        if (sousBonusAmount > 0) {
            this.cartPageSousCount
                .removeClass('disabled')
                .addClass('active')
                .text(textValue);
        } else {
            this.cartPageSousCount
                .removeClass('active')
                .addClass('disabled')
                .text(textValue);
        }
    }

    updateCards() {
        for (let i = 0; i < this.state.storage.length; i++) {
            let cartItem = this.state.storage[i];
            let productBtn = $(`[data-productid="${cartItem.id}"]`);

            if (productBtn.length <= 0) continue;

            if (!cartItem.mId) {
                let regulator = productBtn.prev();
                    productBtn.addClass('disabled');
                    regulator.addClass('active');
                    regulator.find('[data-role="dish-amount"]').text(cartItem.quantity);
            } else {
                let modButton = $(`[data-modification="${cartItem.mId}"]`);
                modButton.click();
            }
            
        }
    }

    updateCard(data) {
        let productBtn = $(`[data-productid="${data.id}"]`);

        if (productBtn.length <= 0) return false;
        
        let regulator = productBtn.prev();

        if (data.mId) {
            let modButton = $(`[data-modification="${data.mId}"]`);
            this.switchModification(modButton);
        }
        regulator.find('[data-role="dish-amount"]').text(data.quantity);

        if (data.quantity === 0) {
            this.hideRegulator(regulator);
        }

        
    }

    applyCustomScroll() {
        this.scrollBar = new SimpleBar(this.widget[0]);
    }

    countSumm() {
        let summ = this.state.storage.reduce((previous, item) => {
            let price = parseInt(item.price, 10),
                nextValue = item.quantity * price;
            return previous + nextValue;
        }, 0);

        return summ;
    }

    countItems() {
        let counter = this.state.storage.reduce((previous, item) => {
            return previous + item.quantity;
        }, 0);

        return counter;
    }

    countBonusAmount(type) {
        if (localStorage.getItem('bonuses')) {
            return JSON.parse(localStorage.getItem('bonuses')).length;
        } return 0;
    }

    countCategoryAmount(category_id) {
        let counter = this.state.storage.reduce((previous, item) => {
            if (parseInt(item.category_id, 10) === category_id) {
                console.log(item);
                return previous + item.quantity;
            } else {
                return previous;
            }
        }, 0);

        return counter;
    }

    updateItem(item, quantity) {
        let index = this.findProductIndex(item);
        this.state.storage[index].quantity = quantity;
    }

    findProductIndex(product) {
        return this.state.storage.findIndex(item => { 
            if(+item.id === +product.id && +item.mId === +product.mId) return item; 
        });
    }

    reachGoal(id) {
        if (typeof yaCounter47772808 !== 'undefined') {
            yaCounter47772808.reachGoal(id);
        }
    }

}



export default Cart;