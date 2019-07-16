export default class Header {

	constructor() {
		this.DOMMap = {

			// Desctop elements
			mobileBtn: $('[data-role="toggle-menu"]'),
			windowObj: $(window),
			menuWrap: $('.header-wrapper'),
			menuContainer: $('.header-wrapper').parent(),

			// Mobile elements
			mobileHeader: $('.header'),
			mobileNav: $('[data-role="header-mobile-nav"]'),
			
		};

		this.MOBILE_BREAKPOINT = 990;
		this.WINDOW_WIDTH = this.DOMMap.windowObj.width();
		this.menuOffsetTop = (this.DOMMap.menuWrap.length && this.DOMMap.menuWrap.offset().top) || 100;
		this.menuHeight = this.DOMMap.menuWrap.height();
		this.mobileMenuHeight = this.DOMMap.mobileHeader.height();

	}

	isMobile = () => this.WINDOW_WIDTH <= this.MOBILE_BREAKPOINT;

	init () {
		this.initHandlers();
		this.applyMenuStyles(this.DOMMap.windowObj.scrollTop());

		if (this.isMobile()) {
			this.shiftNavToActiveCategory();
		}
	}

	initHandlers() {

		this.DOMMap.mobileBtn.on('click', () => {
			$('.menu').slideToggle(300);
			$('body').toggleClass('body-freez');
			this.DOMMap.mobileBtn.toggleClass('button__menu-active');	
		});

		this.DOMMap.windowObj.on('scroll', () => {
			let scrolled = this.DOMMap.windowObj.scrollTop();
			this.applyMenuStyles(scrolled);   
		});

	}

	applyMenuStyles(scrolled) {
		if (scrolled >= this.menuOffsetTop) {
			if (this.isMobile()) {
				this.DOMMap.mobileNav.addClass('fixed');
				this.DOMMap.menuContainer.css('height', this.mobileMenuHeight + 'px');				
			} else {
				this.DOMMap.menuWrap.addClass('menu_fixed');
				this.DOMMap.menuContainer.css('height', this.menuHeight + 'px');
			}
		} else {
			if (this.isMobile()) {
				this.DOMMap.mobileNav.removeClass('fixed');
				this.DOMMap.menuContainer.css('height', 'auto');				
			} else {
				this.DOMMap.menuWrap.removeClass('menu_fixed');  
				this.DOMMap.menuContainer.css('height', 'auto');
			}
		}
	}

	shiftNavToActiveCategory() {
		let activeLink = this.DOMMap.mobileNav.find('a.active'),
			activeLinkParent = activeLink.parent();
		if (activeLink.length == 0) return;

		let activeItemOffsetLeft = activeLinkParent.offset().left,
			elemWidthHalf = activeLinkParent.width() / 2,
			menuWidthHalf = this.DOMMap.mobileNav.width() / 2,
			shift = activeItemOffsetLeft - menuWidthHalf + elemWidthHalf;

		$('.header__mobile-nav-wrap').animate({ scrollLeft: shift }, 200)
	}

}

export  function initMenu() {

	var MOBILE_BREAKPOINT = 990;


	if ($(window).width() < 990) {
		initMobileNav();
		return;
	}
		
		
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
}
