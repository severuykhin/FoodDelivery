/**
 *   Основной модуль приложения, 
 *   в котором содержаться общие методы
 *   используемые другими модулями
 * 
 **/ 

 const App = (function (d,w,b) {

    var roleLazyLoad = '[data-lazy]';

    return {

        sendMetrika : function(goal) {
            if (typeof yaCounter47772808 !== 'undefined') {
                yaCounter47772808.reachGoal(goal);
            }

            return true;
        },

        lazyLoad : {
            showVisible  :  function () {
                var allImages = App.getAll(roleLazyLoad),
                    len       = allImages.length;

                    for (var i = 0; i < len; i++) {

                        var img = allImages[i];

                        var realSrc = img.getAttribute('data-lazy');

                        if (!realSrc) continue;

                        img.src = realSrc;

                        img.removeAttribute('data-lazy');
                    } 

                    return false;
            },

            init : function () {
                App.lazyLoad.showVisible();
                App.findIndexPolyfill();
            }
        },

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

        _append    : function (parent, elems) {
            
            if (elems) {
                let len = elems.length;

                for (let i = 0; i < len; i++) {
                    parent.appendChild(elems[i]);
                }
            }

            return false;
        },

        showModal  :  function (template) {
            let overlay = this._createElem('div', 'overlay', 'overlay');
            let modal   = this._createElem('div', 'modal', 'dish-modal'); 
            let close   = this._createElem('div', 'modal-close', 'modal-close');

            if (template) {

                if (typeof template === 'string') {
                    modal.innerHTML = template;
                } else if (typeof template === 'object') {
                    modal.appendChild(template);
                }
            } else {
                modal.textContent = 'Ой, что то пошло не так';
            }
            this._append(modal, [close]);
            this._append(b, [overlay, modal]);

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

            return false;
        },

        cache    : function (key, value) {
            if (typeof value == 'undefined') {
                return this.cache[key];
            }

            this.cache[key] = value;

            return false;
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
        },

        showElement : function (element) {
            element.style.display = 'block';

            return setTimeout(function () {
                element.style.opacity = 1;
                element.style.transform = 'translateY(0)';
            }, 200);
        },

        hideElement : function (element) {
            element.style.opacity = 0;
            element.style.transform = 'translateY(4px)';

            return setTimeout(function () {
                element.style.display = 'none';
            }, 200);
        },

        findIndexPolyfill() {
            // IE 11 polifyll for array method findIndex()
            Array.prototype.findIndex = Array.prototype.findIndex || function(callback) {
                if (this === null) {
                  throw new TypeError('Array.prototype.findIndex called on null or undefined');
                } else if (typeof callback !== 'function') {
                  throw new TypeError('callback must be a function');
                }
                var list = Object(this);
                // Makes sures is always has an positive integer as length.
                var length = list.length >>> 0;
                var thisArg = arguments[1];
                for (var i = 0; i < length; i++) {
                  if ( callback.call(thisArg, list[i], i, list) ) {
                    return i;
                  }
                }
                return -1;
            };
        }
    };

 })(document, window, document.body);

 export default App;