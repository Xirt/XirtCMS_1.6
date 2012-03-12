/**
 * Creates / Manages XList for backend
 */
var XList = new Class({

	Implements: [Options, Events],

	options: {
		
		sortable: false, // Toggles sorting
		options: true,   // Unused yet
		sortables: [],	  // The columns that can be sorted
		column: 'id',    // The column to sort on (init)
		order: 'ASC',    // The order to sort (init)
		limit: 999       // The limit (init)

	},

	list: [],
	column: null,
	order: 'ASC',
	columns: [],
	limit: 999,
	
	// MEHOD :: CONSTRUCTOR
	initialize: function(component, options) {

		this.table	   = $('table');
		this.component = component;
		this.container = $('container');
		this.scrollbox = this.table.getElement('.box-scroll'); 

		// Override options
		this.setOptions(options);

		// Initialize table headers
		Array.each(this.table.getElements('th'), function(el) {

			var column = el.className.substr(5);
			this.columns.push(column);	 

			if (this.options.sortable && this.options.sortables.contains(column)) {
				
				el.addClass('sortable').store('column', column);
				el.addEvent('click', this._onSort.bind(this));
				
			}

		}, this);

		// Initialize
		this._resize();
		this.initLanguageBox();
		this.setColumn(this.options.column);
		this.setOrder(this.options.order);
		this.setLimit(this.options.limit);
		
		// Triggers
		window.addEvent('resize', this._resize.bind(this));

	},

	// Initializes the language box (optional)
	initLanguageBox: function() {

		XManager.language = Cookie.read('xlist_l');
		$$('.list-iso').each(function(el, key) {

			el.addEvent('click', function() {

				XManager.language = this.getAttribute('alt');
				Cookie.write('xlist_l', XManager.language);
				XManager.reload();

				$$('.list-iso').each(function(el) {
					el.removeClass('active');
				});
	 
				this.addClass('active');
			});

			if (el.getAttribute('alt') == XManager.language || !key) {
				el.fireEvent('click');
			}

		});

	},

	// Loads the entire list
	load: function() {

		new Request.JSON({
			onFailure: Xirt.showError,
			onSuccess: this._receive.bind(this),
			url: 'index.php'
		}).post({
			content: this.component,
			task: 'show_content_list',
			column: this.column,
			order: this.order,
			limit: this.limit,
			iso: XManager.language
		});
		
		this._onLoad();
	},

	// Reloads the entire list
	reload: function() {
		this.load();
	},

	// Shows the entire list
	_receive: function(json) {

		this.list = new Array();
		Array.each(json, function(item) {
			this.list[this.list.length] = item;
		}, this);

		this._show();

	},

	_show: function() {

		this.empty();
		this.list.length ? this.show() : this.onEmpty();
		this._style();

	
		if (this.options.sortable && !this.options.sortables.length) {
			
			new Sortables(this.container, {
				opacity: 0.5,
				onStart: function() {},
				onSort: function() {}
			});

			el.addClass('sortable').store('column', column);
			
		}

	},
	
	_resize: function() {

		this.scrollbox.setStyles({
			'max-height' : Math.max(window.getSize().y - 325, 200)
		});

	},

	show: function() {

		Array.each(this.list, function(item, key) {

			var row = this.createRow(true, true);

			Array.each(this.columns, function(header) {
				
				row.grab(new Element('td', {
					'class': 'cell-' + header,
					'text': item[header] ? item[header] : '--'
				}));
				
			}, this);
			
			this.container.grab(row);
			
		}, this);
		
	},

	// Loads an item from the list (for replacing)
	update: function(xId) {

		new Request.JSON({
			onFailure: Xirt.showError,
			onSuccess: this._replace.bind(this),
			url: 'index.php'
		}).post({
			content: this.component,
			task: 'show_item',
			xid: xId
		});

	},

	// Updates an item from the list
	_replace: function(replacement) {

		if ($defined(replacement)) {
			var xId = replacement.xid;
			var key = this.remove(xId, true);
			key ? key : this.list.length;
			this.list[key] = replacement;
			this._sort();
			this.show();
		}

	},

	// Adds item xId to the list
	add: function(xId) {
		this.update(xId);
	},

	remove: function(xId, iCall) {

		for (var key in this.list) {
			if (this.list[key].xid == xId) {
				delete this.list[key];
				break;
			}

			key = null;
		}

		iCall ? $empty : this.show();
		return key;
	},

	// Empties the list
	empty: function() {
		this.container.empty();
	},
	
	setColumn: function(column) {
		
		// Modify list order
		this.order = (this.order == 'ASC') ? 'DESC' : 'ASC';
		this.order = (this.column == column) ? this.order : 'ASC';
		this.column = column;
		
		// Modify style on headers
		Array.each(this.table.getElements('th'), function(el) {

			el.removeClass('DESC').removeClass('ASC');
			if (el.retrieve('column') == column) {
				el.addClass(this.order);
			}

		}, this);
		
	},
	
	setOrder: function(order) {	
		this.order = (order == 'ASC') ? 'DESC' : 'ASC';
		this.setColumn(this.column);
	},
	
	setLimit: function(limit) {
		this.limit = Math.abs(limit);
	},

	// (Re-)Style list
	_style: function() {

		Array.each(this.container.getElements('tr'), function(row, i) {
			row.className = 'r' + i % 2;
		});

	},

	/******************
	  onEvent-methods
	******************/
	// Shows 'no result' for list
	onEmpty: function(span) {

		this.empty();

		var row = new Element('tr');

			new Element('td', {
				'text' : XLang.messages['empty'],
				'class' : 'table-empty',
				'colspan' : span ? span : 1
			}).inject(row);

		this.container.grab(row);

	},

	// Shows 'loading' for list
	_onLoad: function(span) {

		this.empty();

		var row = new Element('tr');

			var cell = new Element('td', {
				'class' : 'table-loading',
				'colspan' : span ? span : 1
			});

				cell.grab(new Element('img', {
					'src' : '../images/cms/loader-bar.gif'
				}));
				
			row.grab(cell); 
				
		this.container.grab(row);
		this._style();

	},

	// Sorts items in list
	_onSort: function(e) {
		
		this.setColumn(e.target.retrieve('column'));
		this.reload();
		
	},


	/****************
	  MISCELLANEOUS
	****************/
	// Create a new row
	createRow: function(isMain, published) {

		var el = new Element('tr');

		if (published == 0) {
			el.setStyle('backgroundColor', '#ffd093');
		}

		if (!isMain) {
			el.setStyle('backgroundColor', '#feb3b3');
		}

		return el;
	}

});
