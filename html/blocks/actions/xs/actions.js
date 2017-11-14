!function ($) {

	if ($('[data-role="actions"]').length > 0) {
		$('[data-role="actions"]').slick({
        dots           : true,
        adaptiveHeight : true,
        fade           : true,
        prevArrow      : '',
        nextArrow      : ''
    });
	}
}(jQuery)