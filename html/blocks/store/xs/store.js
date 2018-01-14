var Store = (function (w,d,$) {

	var block 	  = '[data-role="store-category"]',
		routeAttr = 'data-route',
		mainButon = '[data-role="filter-main"]';

	return {
		filterBlocks     : function (route) {
			var blocks = _.getAll(block),
				len    =  blocks.length;

			if (route == '' || route == 'all') {
				Store._showAll(blocks);
				return false;
			}  

			for (var i = 0; i < len; i++) {
				var thisRoute = blocks[i].getAttribute(routeAttr);

				if (thisRoute === route) {
					_.showElement(blocks[i]);
				} else {
					_.hideElement(blocks[i]);
				}
			}

			return false;
		},
		_showAll         : function (blocks) {
			var len = blocks.length;

			for (var i = 0; i < len; i++) {
				_.showElement(blocks[i]);
			}

			return false;
		},
		renderRoute      : function (route) {
			Filter.changeButtons(route);
			Store.filterBlocks(route);
		},
		registerHandlers : function () {
			w.addEventListener('hashchange', function () {
				Store.renderRoute( Filter.getUrl() );
			});

			w.addEventListener('DOMContentLoaded', function () {
				Store.renderRoute( Filter.getUrl() );
			});

			return false;
		},

		init : function () {
			this.registerHandlers();

			return false;
		}
	};

})(window,document, jQuery);

if (_.getElem('[data-role="store"]') != null) {
	Store.init();
}
