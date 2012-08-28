var Slideshows = Slideshows ? Slideshows : new Class({
	
	slideshows : [],
	
	initialize: function() {

		// Capture all slideshows
		Array.each($$('.x-mod-image-slideshow'), function(el) {
			
			var image = el.getElement('img');
			var dimensions = image.getSize();

			// Configure slideshow box
			el.setStyles({
				'position' : 'relative',
				'width'    : dimensions.x + 'px',
				'height'   : dimensions.y + 'px',
				'overflow' : 'hidden'
			});
			
			// Save slideshow
			this.slideshows.push({
				current : 0,
				images  : el.getElements('img')
			});
			
		}, this);

		this._init();
		
	},
	
	// Initialize slideshows
	_init: function () {

		// Configure slideshow images
		Array.each(this.slideshows, function(slideshow) {

			Array.each(slideshow.images, function (el, key) {
	
				el.setStyles({
					'position' : 'absolute',
					'opacity'  : key ? 0 : 1,
					'top'	     : 0,
					'left'     : 0
				});
				
			});

		});
		
		// Start slideshow
		this.show.periodical(5000, this);
	},
	
	// Activate slideshows
	show: function() {
		
		Array.each(this.slideshows, function(slideshow) {

			if (slideshow.images.length) {

				slideshow.images[slideshow.current].fade(0);
	
				if (slideshow.current < slideshow.images.length - 1) {
					slideshow.current = slideshow.current + 1;
				} else {
					slideshow.current = 0;
				}
				
				slideshow.images[slideshow.current].fade('in');

			}

		});

	}
	
});

window.addEvent('load', function() {
	new Slideshows();
});