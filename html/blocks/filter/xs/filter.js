var Filter = (function (w,d,$) {

	var button = '[data-role="filter-button"]',
		active = 'filter__item-active';

	return {
		changeButtons : function (route) {
			var buttons = _.getAll(button), 
				len     = buttons.length; 

			[].forEach.call(buttons, function (i) {
				var hash = i.hash.substring(1);

				if (hash === route) {
					i.classList.add(active);
				} else {
					i.classList.remove(active);
				}
			});

			return this;
		},
		getUrl : function () {
			return w.location.hash.substring(1);
		},
		setUrl : function (hash) {
			w.location.hash = hash;
			
			
			return this;
		}
	};

})(window, document, jQuery);