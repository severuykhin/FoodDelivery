import widgetItemTemplate from './widgetTemplate';
import pageItemTemplate from './rawTemplate';
import mobileWidget from './mobileWidget';

class Cart {

    constructor() {

        this.modBtns = document.querySelectorAll('[data-role="modification-button"]');
        this.summ = document.querySelector('[data-role="cart-widget-summ"]');
        this.summBottom = document.querySelector('[data-role="cart-widget-summ-bottom"]');
        this.count = $('[data-role="cart-counter"]');
        this.widget = $('[data-role="cart-widget"]');
        this.cartPage = $('[data-role="cart-page"]');

        this.scrollBar = null;

        this.csrfParam = $('[name="csrf-param"]').attr('content');
        this.csrfContent = $('[name="csrf-token"]').attr('content');

        this.widgetOrderBtn = $('[data-role="cart-widget-order-button"]');

        this.form = $('[data-role="cart-order-form"]');
        this.orderStub = $('[data-role="cart-order-stub"]');

        this.state = {
            storage: []
        };
    }

    init() {
        this.initHandlers();
        this.actualize();

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

        this.state.storage = initialState;
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

    removeFromCart(removeButton) {
        let product = removeButton.attr('data-product');

        try {
            product = JSON.parse(product);
        } catch(e) {
            throw e; // Some useful stuff if error
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
            html += pageItemTemplate(item);
        });

        html += `<div class="cart-page__row cart-page__row_result"><div class="cart-page__name">Сумма заказа: <span class="cart-page__totalPrice">${summ} руб.</span></div></div>`;

        this.cartPage.html(html);

        if (summ < 450) {
            this.form.hide();
            this.orderStub.show();
        } else {
            this.form.show();
            this.orderStub.hide();
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