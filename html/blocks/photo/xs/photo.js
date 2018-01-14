window.onload = function () {
    if (document.querySelector('[data-lazyload="true"]') !== null) {
        App.lazyLoad.init();
    }
};