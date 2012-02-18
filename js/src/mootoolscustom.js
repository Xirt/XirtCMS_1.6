/**
 * Multiple select - Replaces multiple-select with a stylish list
 *
 * Based on MultipleSelect by Michael Aufreiter (http://www.wollzelle.com)
 */
var MultipleSelect = new Class({

	Implements: [Events, Options],

	options: {
		className: 'multiple-select'
	},

	// Initializes the multiple select-list
	initialize: function(el, options) {

		// Hide / analyse old list (SELECT-tag)
		this.original = $(el).setStyle('display', 'none');

		var dimensions = this.original.measure(function(){
			return this.getSize();
		});

		this.element = new Element('ul', {
			'id': el.name + '_choices',
			'class': this.options.className
		}).setStyles({
			width : dimensions.x + 'px',
			height: dimensions.y + 'px'
		}).inject(this.original, 'after');

		this.setOptions(options);
		this._create();

	},

	// Creates UL-list from SELECT-list
	_create: function() {

		for(i = 0; i < this.original.length; i++) {
			
			var option = new Element('li', {
				'id'	  : this.original.name + '_' + i,
				'text'  : this.original.options[i].text,
				'class' : this.original.options[i].selected ? 'selection' : ''
			}).addEvent('mousedown', this.updateSelection.bind(this.original));

			this.element.grab(option);

		};

		this.update();
	},

	// Synchronizes lists
	update: function() {

		for(i = 0; i < this.original.length; i++) {

			var current = $(this.original.name + '_' + i);
			
			current.removeClass('selected');
			if (this.original.options[i].selected) {
				current.addClass('selected');
			}

		}

	},

	// Updates selection
	updateSelection: function(e) {

		var target = e.target;
		var targetId = target.id;

		var id = targetId.substring(targetId.lastIndexOf('_') + 1);
		var selected = this.options[id].selected;;

		this.options[id].set('selected', selected ? '' : 'selected');
		target.toggleClass('selected');

		this.fireEvent('change');

	}

});


/**
 * Roar - Notifications
 *
 * Inspired by Growl
 *
 * @version	  1.1.0
 *
 * @license		MIT-style license
 * @author		Harald Kirschner <mail [at] digitarald.de>
 * @copyright	Author
 */
var Roar = new Class({

	Implements: [Options, Events, Chain],

	options: {
		duration: 3000,
		position: 'upperLeft',
		container: null,
		bodyFx: null,
		itemFx: null,
		margin: {x: 10, y: 10},
		offset: 10,
		className: 'roar',
		onShow: function() {},
		onHide: function() {},
		onRender: function() {}
	},

	initialize: function(options) {
		this.setOptions(options);
		this.items = [];
		this.container = $(this.options.container) || document;
	},

	alert: function(title, message, options) {
		arguments = Array.clone(arguments);
		var params = arguments.link({title: Type.isString, message: Type.isString, options: Type.isObject});
		var items = [new Element('h3', {'html': title})];
		if (message) items.push(new Element('p', {'html': message}));
		return this.inject(items, options);
	},

	inject: function(elements, options) {
		if (!this.body) this.render();
		options = options || {};

		var offset = [-this.options.offset, 0];
		var last = this.items.getLast();
		if (last) {
			offset[0] = last.retrieve('roar:offset');
			offset[1] = offset[0] + last.offsetHeight + this.options.offset;
		}
		var to = {'opacity': 1};
		to[this.align.y] = offset;

		var item = new Element('div', {
			'class': this.options.className,
			'opacity': 0
		}).adopt(
			new Element('div', {
				'class': 'roar-bg',
				'opacity': 0.7
			}),
			elements
		);

		item.setStyle(this.align.x, 0).store('roar:offset', offset[1]).set('morph', Object.merge({
			unit: 'px',
			link: 'cancel',
			onStart: Chain.prototype.clearChain,
			transition: Fx.Transitions.Back.easeOut
		}, this.options.itemFx));

		var remove = this.remove.pass(item, this);
		this.items.push(item.addEvent('click', remove));

		if (this.options.duration) {
			var over = false;
			var trigger = (function() {
				trigger = null;
				if (!over) remove();
			}).delay(this.options.duration);
			item.addEvents({
				mouseover: function() {
					over = true;
				},
				mouseout: function() {
					over = false;
					if (!trigger) remove();
				}
			});
		}
		item.inject(this.body).morph(to);
		return this.fireEvent('onShow', [item, this.items.length]);
	},

	remove: function(item) {
		var index = this.items.indexOf(item);
		if (index == -1) return this;
		this.items.splice(index, 1);
		item.removeEvents();
		var to = {opacity: 0};
		to[this.align.y] = item.getStyle(this.align.y).toInt() - item.offsetHeight - this.options.offset;
		item.morph(to).get('morph').chain(item.destroy.bind(item));
		return this.fireEvent('onHide', [item, this.items.length]).callChain(item);
	},

	empty: function() {
		while (this.items.length) this.remove(this.items[0]);
		return this;
	},

	render: function() {
		this.position = this.options.position;
		if (typeOf(this.position) == 'string') {
			var position = {x: 'center', y: 'center'};
			this.align = {x: 'left', y: 'top'};
			if ((/left|west/i).test(this.position)) position.x = 'left';
			else if ((/right|east/i).test(this.position)) this.align.x = position.x = 'right';
			if ((/upper|top|north/i).test(this.position)) position.y = 'top';
			else if ((/bottom|lower|south/i).test(this.position)) this.align.y = position.y = 'bottom';
			this.position = position;
		}
		this.body = new Element('div', {'class': 'roar-body'}).inject(document.body);
		if (Browser.ie) this.body.addClass('roar-body-ugly');
		this.moveTo = this.body.setStyles.bind(this.body);
		this.reposition();
		if (this.options.bodyFx) {
			var morph = new Fx.Morph(this.body, Object.merge({
				unit: 'px',
				chain: 'cancel',
				transition: Fx.Transitions.Circ.easeOut
			}, this.options.bodyFx));
			this.moveTo = morph.start.bind(morph);
		}
		var repos = this.reposition.bind(this);
		window.addEvents({
			scroll: repos,
			resize: repos
		});
		this.fireEvent('onRender', this.body);
	},

	reposition: function() {
		var max = document.getCoordinates(), scroll = document.getScroll(), margin = this.options.margin;
		max.left += scroll.x;
		max.right += scroll.x;
		max.top += scroll.y;
		max.bottom += scroll.y;
		var rel = (typeOf(this.container) == 'element') ? this.container.getCoordinates() : max;
		this.moveTo({
			left: (this.position.x == 'right')
				? (Math.min(rel.right, max.right) - margin.x)
				: (Math.max(rel.left, max.left) + margin.x),
			top: (this.position.y == 'bottom')
				? (Math.min(rel.bottom, max.bottom) - margin.y)
				: (Math.max(rel.top, max.top) + margin.y)
		});
	}

});