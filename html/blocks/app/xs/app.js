/**
 *   Основной модуль приложения, 
 *   в котором содержаться общие методы
 *   используемые другими модулями
 * 
 **/ 

 const App = (function (d,w,b) {

    return {

        _createElem : function (type, className, role) {
            let elem = d.createElement(type);

            if (className) {
                elem.classList.add(className);
            }

            if (role) {
                elem.setAttribute('data-role', role);
            }

            return elem;
        },

        _append    : function (elems) {
            
            if (elems) {
                let len = elems.length;

                for (let i = 0; i < len; i++) {
                    b.appendChild(elems[i]);
                }
            }

            return false;
        },

        showModal  :  function (template) {
            let overlay = this._createElem('div', 'overlay', 'overlay');
            let modal   = this._createElem('div', 'modal', 'dish-modal'); 

            if (template) {

                if (typeof template === 'string') {
                    modal.innerHTML = template;
                } else if (typeof template === 'object') {
                    modal.appendChild(template);
                }
            } else {
                modal.textContent = 'Ой, что то пошло не так';
            }

            this._append([overlay, modal]);

            overlay.style.display = 'block';
            modal.style.display   = 'block';

            setTimeout( function () {
                overlay.style.opacity = 1;
                modal.style.opacity   = 1;
            }, 300 );

            return false;
        },
        removeModal  : function () {
            if (
                this.getElem('.overlay') !== null && 
                this.getElem('.modal') !== null
            ) {
                let modal   = document.querySelector('.modal');
                let overlay = document.querySelector('.overlay');

                modal.style.opacity   = 0;
                overlay.style.opacity = 0;

                setTimeout(function () {
                    modal.remove();
                    overlay.remove();
                }, 300);
            }
        },

        cache    : function (key, value) {
            if (typeof value == 'undefined') {
                return this.cache[key];
            }

            this.cache[key] = value;
        },

        getElem  :  function (selector) {
            if (!this.cache(selector)) {
                this.cache(selector, d.querySelector(selector));
            }

            return this.cache(selector);
        },

        getAll   : function (selector) {
            if (!this.cache(selector)) {
                this.cache(selector, d.querySelectorAll(selector));
            }

            return this.cache(selector);
        }
    };

 })(document, window, document.body);

 window._ = App;