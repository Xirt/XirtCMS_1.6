/**
 * Various XirtCMS elements
 */
var XTypes = {

	Pointer : 0,
	Window : 1,
	Message : 2

};



/**
 * Xirt main class
 */
var Xirt = new Class({

	initialize : function() {
		
		this._analyse();
		this._statistics();
		this._notifications();

		// Check for (old) browser version
		if ((Browser.version < 8 && Browser.ie) || 
			 (Browser.firefox && Browser.version < 4)) {
			Asset.javascript('js/xupdate.js');
		}
		
	},

	// Analyses elements
	_analyse : function() {
		
		// Tooltips
		new Tooltips('a.tooltip|img.tooltip');

		// External links
		$$('a[rel*=external]').each(function(el) {

			el.setProperty('target', '_blank');
			el.addClass('external');

		});

		// Links to PDF files
		Array.combine($$('a[rel*=pdf]'), $$('a[href$=.pdf]')).each(function(el) {

			el.addEvent('click', function(e) {

				new PDF(e, this);
			  
			});

		});

	},

	// Enables Roar-notifications
	_notifications : function() {

		this.roar = new Roar({
			position : 'upperRight'
		});

	},

	// Optional statistics
	_statistics : function() {

		var container = $('xStatsBox');
		if (typeOf(container) == 'element') {

			container.addEvent('click', function() {
				this.fade();
			});

		}

	},

	/*******************
	 * MESSAGE RELATED *
	 ******************/
	// Shows a new window (popup)
	showWindow : function(content, w) {
		return new Window(content, w);
	},

	// Shows an alert (centered)
	showMessage : function(txt) {
		new Message(txt);
	},

	// METHOD: Show a notice
	showNotice : function(msg) {
		Xirt.roar.alert(XLang.messages['system'], msg);
	},

	// METHOD: Show an (AJAX) error
	showError : function() {
		Xirt.roar.alert(XLang.messages['system'], XLang.errors['communication']);
	},

	// METHOD :: Show a tooltip
	showPointer : function(el, txt) {
		new Pointer(el, txt);
	},

	// METHOD: Hides all pointers
	hidePointers : function() {

		Array.each(XRegister.toArray(XTypes.Pointer), function(item) {
			item.hide();
		});

	},

	// METHOD: Hides all pointers (deprecated)
	hideTooltips : function() {

		Xirt.showNotice("Deprecated use of Xirt.hideTooltips();");
		this.hidePointers();

	},

	/*****************
	 * MISCELLANEOUS *
	 ****************/
	// METHOD :: Populates field of a form with values given
	populateForm : function(form, data) {

		Object.every(data, function(value, key) {

			var element = form.getElement('[name=x_' + key + ']');
			if (typeOf(element) == 'element') {
				return element.set('value', value);
			}

			var element = form.getElement('[name=' + key + ']');
			if (typeOf(element) == 'element') {
				return element.set('value', value);
			}

			return true;
		}, this);

	}

});



/**
 * Register for active XirtCMS elements
 */
var XRegister = new Class({

	_storage : [],

	// Registers item
	add : function(item) {
		this._storage[this._storage.length] = item;
	},

	// Unregisters item
	remove : function(item) {
		this._storage.erase(item);
	},

	// Checks whether an item is registered
	isRegistered : function(id) {

		var list = Array.filter(this._storage, function(item) {
			return (item.id == id);
		});
		
		return list.length ? list[0] : null;
	},

	// Returns registered items
	toArray : function(type) {

		return Array.filter(this._storage, function(item) {
			return (item.type == type);
		}, this);

	}

});

window.addEvent('domready', function() {

	Xirt = new Xirt();
	XRegister = new XRegister();

});



/**
 * Creates a window (popup) with given content
 */
var Window = new Class({

	Implements : [ Options, Events ],

	type : XTypes.Window,
	options : {
		'width' : 750
	},

	initialize : function(content, w) {

		this.fog = new Fog();

		this._create(w);
		this._register();
		this.set(content);

	},

	// Sets the content
	set : function(content) {

		if (typeof (content) != 'string') {
			this.content.grab(content);
		} else {

			var box = new Element('div', {
				'class' : 'box-buttons'
			});

			box.grab(new Element('button', {
				'class' : 'close xButton',
				'text' : XLang.misc['close']
			}));

			this.content.set('html', content);
			this.element.grab(box);

		}

		Array.each(this.element.getElements('.close'), function(el) {
			el.addEvent('click', this.hide.bind(this));
		}, this);

	},

	// Registers the element
	_register : function() {

		XRegister.add(this);
		window.addEvent('resize', this._reposition.bind(this));

		if (Browser.ie) {
			window.addEvent('scroll', this._reposition.bind(this));
		}

	},

	// Positions the element
	_position : function() {

		this.element.position({
			relativeTo : $(document.body),
			ignoreScroll : true,
			relFixedPosition : Browser.ie ? true : false,
			position : 'centerTop',
			edge : 'centerTop'
		});

		// Note: IE7+ requires 'standards mode'
		this.element.setStyle('position', 'fixed');

	},

	// Shows the window
	show : function() {

		this.fog.show();
		Xirt.hidePointers();
		this.element.reveal();

	},

	// Hides the window
	hide : function() {

		this.element.dissolve();
		Xirt.hidePointers();
		this.fog.hide();

	},

	// Remove window (completely)
	removeWindow : function(window) {

		Xirt.showNotice("Deprecated use of Window.removeWindow()");

		window = $(window);
		if (!window || !window.isVisible()) {
			return false;
		}

		// unregister
		Xirt.window.dispose();

	},

	// METHOD :: Resizes windows after a window resize
	_reposition : function() {

		if (this.element.isVisible()) {
			this._position();
		}

	},

	// METHOD :: Creates pop-up if not available
	_create : function(w) {

		this.element = new Element('div', {
			'class' : 'xirt-window'
		}).setStyles({
			'width' : w ? w : 750 + 'px'
		}).inject(document.body).hide();

		this.content = new Element('div', {
			'class' : 'xirt-content'
		}).setStyles({
			'max-height' : Math.max(window.getSize().y - 75, 250) + 'px'
		}).inject(this.element);

		this._position();

	}

});


var Tooltips = new Class({
	
	Extends: Tips,
	
	initialize: function(el, options) {

		var options = options ? options : {};
		
      // Override default show behavior
		if (typeof(options.onShow) == 'undefined') {

			options.onShow = function(tip, el){
				tip.fade('hide');
				tip.fade('in');
			};

		}

		// Override default hide behavior
		if (typeof(options.onHide) == 'undefined') {

			options.onHide = function(tip, el){
				tip.fade('out');
	      };

		}

		// Add hide behavior (for dynamic pages)
		if (typeof(options.onAttach) == 'undefined') {
			
			options.onAttach = function(el) {
				el.addEvent('click', this.hide.bind(this));
			}.bind(this);
			
		}


		// Override default delays
		if (typeof(options.showDelay) == 'undefined') {
			options.showDelay = 500;
		}

		// Seperate title / content
	   Array.each($$(el), function(element, index) {

	   	var content = element.get('title');
	   	var parts = content.split('::');
	   	
	   	element.store('tip:title', parts[1] ? parts[0] : XLang.misc['desc']);
			element.store('tip:text', parts[1] ? parts[1] : content);
			
      });
		
		this.parent(el, options);
	}

	
});


/**
 * Creates a pointer next to an element (right side)
 */
var Pointer = new Class({

	Implements : [ Options ],

	type : XTypes.Pointer,

	initialize : function(el, txt, options) {

		this.setOptions(options);

		this._create(txt);
		this._attach(el);
		this._register();
		this.show();

	},

	// Creates the pointer
	_create : function(txt) {

		this.element = new Element('div', {
			'class' : 'xirt-pointer'
		}).fade('out');

		this.set(txt);
		this.element.inject($(document.body));

	},

	// (Re-sets) text of the pointer
	set : function(txt) {

		new Element('p', {
			'text' : txt
		}).inject(this.element.empty());

	},

	// Attach pointer to element
	_attach : function(el) {

		el.pointer = this;
		this.container = el;

		this.element.position({
			relativeTo : el,
			position : 'centerRight',
			edge : 'centerLeft',
			offset : {
				x : +4,
				y : el.getScroll().y
			}
		});

	},

	// Registers the pointer
	_register : function() {
		XRegister.add(this);
	},

	// Shows the pointer
	show : function(label) {

		if (label && label.trim()) {
			this.set(label);
		}

		return this.element.fade('in');
	},

	// Hides the pointer
	hide : function() {
		return this.element.fade('out');
	},

	// Updates pointer on event
	update : function(label) {

		this._attach(this.container);
		this.show(label);

	}

});



/**
 * Creates a message (centered alert)
 */
var Message = new Class({

	Implements : [ Options ],

	type : XTypes.Message,

	initialize : function(txt, options) {

		this.setOptions(options);

		this._create(txt);
		this._position();
		this._register();
		this.show();

	},

	// Creates a message
	_create : function(txt) {

		this.element = new Element('div', {
			'class' : 'xirt-alert',
			'text' : txt
		}).inject(document.body);

		var box = new Element('div', {
			'class' : 'box-buttons'
		}).inject(this.element);

		box.grab(new Element('button', {
			'text' : XLang.misc['close']
		}).addEvent('click', this.hide.bind(this)));

		this.element.grab(box);

	},

	// Position the message (centered)
	_position : function(el) {

		this.element.position({
			relativeTo : $('body'),
			position : 'center',
			edge : 'bottom',
			offset : {
				x : 0,
				y : -100
			}
		}).fade('hide');

	},

	// Registers the message with Xirt
	_register : function() {
		XRegister.add(this);
	},

	// Shows the message
	show : function() {
		return this.element.fade('in');
	},

	// Hides the message
	hide : function() {

		XRegister.remove(this);
		return this.element.fade('out');

	}

});



/**
 * Creates a background fog (fullscreen)
 */
var Fog = new Class({

	Implements : Options,

	element : null,
	options : {
		opacity : 0.5
	},

	// Constructor
	initialize : function(options) {

		this.setOptions(options);
		if (!(this.element = $('xBG')) || !this.element) {
			this._create();
		}

	},

	// Creates the element
	_create : function(txt) {

		this.element = new Element('div', {
			'class' : 'xirt-overlay',
			'id' : 'xBG'
		}).inject(document.body);

	},

	// Resizes the element (to full screen size)
	_resize : function() {

		this.element.setStyles({
			'width' : screen.width + 'px',
			'height' : screen.height + 'px'
		});

	},

	// Shows the element
	show : function() {

		this.hide(1);
		this._resize();

		return this.element.fade(this.options.opacity);
	},

	// Hides the element
	hide : function(fast) {
		return this.element.fade(fast ? 'hide' : 'out');
	}

});



/**
 * Class to show a PDF notifications
 */
var PDF = new Class({

	_reader : "http://get.adobe.com/reader/",
	_path : null,

	initialize : function(e, el) {

		if (!Cookie.read('pdf')) {

			this._path = el.get('href');
			Cookie.write('pdf', '1');
			e.stop();

			this._create();
			this.show();

		}

	},

	// Creates the element
	_create : function() {

		this.container = new Element('div', {
			'class' : 'xPDF'
		});
		
			this.container.grab(new Element('h1', {
				'text': XLang.reader['header']
			}));

			this.container.grab(new Element('p', {
				'text': XLang.reader['introduction']
			}));

			var content = new Element('div', {
				'class' : 'box-download'
			});

				content.grab(new Element('button', {
					'type'	 : 'button',
					'text'	 : XLang.reader['download'],
					'class'	: 'xPDF'
				}).addEvent('click', this._download.bind(this)));

			this.container.grab(content);

			this.container.grab(new Element('p', {
				'text': XLang.reader['alternative']
			}));

			var buttons = new Element('div', {
				'class' : 'box-buttons'
			});
	
				buttons.grab(new Element('button', {
					'type'	 : 'button',
					'text'	 : XLang.reader['continue']
				}).addEvent('click', this._continue.bind(this)));

				buttons.grab(new Element('button', {
					'type'	 : 'button',
					'text'	 : XLang.reader['cancel'],
					'class'	: 'close'	  
				}));

			this.container.grab(buttons);

		this.window = new Window(this.container, 500);

	},

	// Continues to requested file
	_continue : function() {

		window.open(this._path);
		this.hide();

	},

	// Continues to PDF reader
	_download: function() {

	  window.open(this._reader);

	},

	// Shows the element
	show : function() {
		this.window.show();
	},

	// Hides the element
	hide : function() {
		this.window.hide();
	}

});



/**
 * Class for submitting forms
 * Prevents MooTools 'bug' #1066 on https://mootools.lighthouseapp.com
 * 
 * Extends: Request (MooTools)
 */
Request.Form = new Class({

	Extends : Request,

	initialize : function(form, options) {

		options = options ? options : {};
		options.data = form;

		this.parent(options);

	}

});



/**
 * Class for mass resetting forms
 * 
 * Extends: Forms (MooTools)
 */
Forms = {
	
	reset : function() {

		Array.each($$('form'), function(el) {
			el.reset();
		});

	}

};