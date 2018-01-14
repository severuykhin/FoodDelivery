$(function () {

	$('[data-role="toggle-menu"]').on('click', function () {
		$('.menu').slideToggle(300);
		$('body').toggleClass('body-freez');
		$(this).toggleClass('button__menu-active');
	});

});