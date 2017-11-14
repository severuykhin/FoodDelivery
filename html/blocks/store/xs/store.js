var Store = (function (w,d,$) {

	var block 	  = '[data-role="store-category"]',
		routeAttr = 'data-route'; 

	return {
		filterBlocks     : function (route) {
			var blocks = _.getAll(block),
				len    =  blocks.length;

			if (route == '') {
				Store._showAll(blocks);
				return;
			}  

			for (var i = 0; i < len; i++) {
				var thisRoute = blocks[i].getAttribute(routeAttr);
				blocks[i].style.display = route === thisRoute ? 'block' : 'none';
			}

			return false;
		},
		_showAll         : function (blocks) {
			console.log(blocks);
			var len = blocks.length;

			for (var i = 0; i < len; i++) {
				blocks[i].style.display = 'block';
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
