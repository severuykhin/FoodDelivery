export default function mobileWidget()
{
    $('.cart-widget__link').on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $.fancybox.open({
            src: '#cart-widget-dropdown',
            touch: false,
            padding: 10

        });
        $('.cart-widget__dropdown').addClass('active');
    });
}