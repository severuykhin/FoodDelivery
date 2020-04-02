class CartGift {

    constructor(config) {
        this.maxValue = config.maxValue;
        this.DOMMap = {
            elem: $('[data-role="cart-gift"]'),
            track: $('[data-role="cart-gift-track"]')
        }
    }

    init(value) {
        this.update(value);
    }

    update(value) {
        let newWidth = parseFloat((value / (this.maxValue / 100)).toFixed(2), 10);
        
        let bgColor = '#ff9a40';
        
        if (newWidth > 100) {
            newWidth = 100;
            bgColor = '#88bd4b';
        }

        this.DOMMap.track.css({
            width: newWidth + '%',
            backgroundColor: bgColor
        });
    }

    show() {
        console.log(this.DOMMap.elem);
        this.DOMMap.elem.show();
    }

    hide() {
        this.DOMMap.elem.hide();
    }

}

export default CartGift;