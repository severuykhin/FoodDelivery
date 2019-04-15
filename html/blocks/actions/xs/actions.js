export default function initActions() {
    if ($('[data-role="slider"]').length > 0) {
		$('[data-role="slider"]').slick({
            dots           : true,
            adaptiveHeight : true,
            fade           : true,
            prevArrow      : '',
            nextArrow      : ''
        });
	}
}