export default function initMenu() {
	$('[data-role="toggle-menu"]').on('click', function () {
		$('.menu').slideToggle(300);
		$('body').toggleClass('body-freez');
		$(this).toggleClass('button__menu-active');
	});

	if ($(window).width() < 990) return;

    
		/**
		* Desktop menu actions
		*/
		
		var windowObj     = $(window);
		var windowWidth   = windowObj.width();
		var menuWrap      = $('.header-wrapper');
		var menuContainer = menuWrap.parent();
		var menuOffsetTop = (menuWrap.length && menuWrap.offset().top) || 100;
		var menuHeight    = menuWrap.height();
		
		var MOBILE_BREAKPOINT = 990;
		
		/**
		* Resolve menu styles via given scroll position
		* @param {number} scrolled - Scrolled pixels 
		*/
		function applyMenuStyles(scrolled) {
			if (scrolled >= menuOffsetTop) {
					menuWrap.addClass('menu_fixed');
					menuContainer.css('height', menuHeight + 'px');
			} else {
					menuWrap.removeClass('menu_fixed');  
					menuContainer.css('height', 'auto');
			}
		}
		
		/**
		* Init fixed menu
		*/
		function fixMenu() {
		
			var scrolled = windowObj.scrollTop();
		
			// Apply styles on window load
			applyMenuStyles(scrolled);
		
			windowObj.on('scroll', function (e) {
					scrolled = windowObj.scrollTop();
					applyMenuStyles(scrolled);   
			});
		
		}
		
		if (windowWidth >= MOBILE_BREAKPOINT) fixMenu();
		
}
