export default function initFancy()
{
    $("[data-fancybox]").fancybox({
        thumbs          : false,
        hash            : false,
        loop            : true,
        keyboard        : true,
        toolbar         : true,
        animationEffect : "fade",
        arrows          : true,
        clickContent    : false
    });
}