var FileTree = new Class({

	Implements: [Events, Options],
	
	_hash: null,
	_list: [],

	// Create a new tree
	initialize: function(el, options) {

		this.setOptions(options);
		this.container = $(el);
		this.load();

	},

	// Loads tree structure
	load: function() {

		new Request.JSON({
			onFailure: Xirt.showError,
			onSuccess: this._receive.bind(this),
			url: 'index.php'
		}).post({
			content: XManager.component,
			task: 'show_tree'
		});

	},

	// Reloads tree structure
	reload: function() {
		this.load();
	},

	// Receives tree structure
	_receive: function(json) {

		if (json.hash != this._hash) {

			this._hash = json.hash;
			this._show(json.tree);

		}

		this.fireEvent('update');
	},

	// Shows tree structure
	_show: function(json) {

		var level = -1;
		var container = null;

		var prevItem = this.container.empty();

		Array.each(json, function(dir) {

			var path = dir.split('/');
			var item = path[path.length - 2];
			var thisLevel = path.length - 2;

			// Go one level deeper (children)
			while (thisLevel > level) {

				container = new Element('ul').inject(prevItem);
				(level > 0 && container.hide());
				level++;
				
			}

			// Return to parent level
			while (thisLevel < level) {

				container = container.getParent('ul');
				level--;

			}

			// Add new item
			prevItem = new TreeNode(this, item, dir);
			this._list.push(prevItem);
			container.grab(prevItem);

		}, this);

	},

	// Change directory to given path (is possible)
	chdir: function(path) {

		return Array.some(this._list, function(folder) {

			if (folder.path == path) {
			
				this._chdir(folder);
				return true;

			}
			
			return false;
		}, this);

	},

	// Change directory (private)
	_chdir: function(folder) {

		var el = folder.element;

		// Open / close tree
		this.container.getElements('ul').each(function(folder) {

			if (el.getChildren().contains(folder) || folder.contains(el)) {
				return (!folder.isVisible() && folder.reveal());
			}
			
			(folder.isVisible() && folder.dissolve());	 
			
		}, this);

		// Updates classes in tree
		this.container.getElements('li').each(function(folder) {
			
			if (folder.contains(el) || el == folder) {
				return folder.addClass('open');					
			}
			
			folder.removeClass('open');	 
		});

		XFileViewer.load(folder.path);
	}

});



var TreeNode = new Class({
	
	initialize: function(tree, name, path) {

		this.name = name;
		this.path = path;
		this.tree = tree;
		
		this.element = new Element('li', {
			'class': 'folder',
			'text': this.name
		});
		
		this.element.path = this.path;
		this.element.addEvent('click', this._onClick);
		
	},
	
	// The onClick-event for this element
	_onClick: function(event) {

		XTreeViewer.chdir(this.path);
		event.stop();

	},
	
	// Returns the current element
	toElement: function() {
		return this.element;
	}
	
});



var PathList = new Class({
	
	initialize: function(el) {

		this.container = $(el);
		this.update();

	},
	
	update: function() {
		
		this.container.empty();

		Array.each(XTreeViewer._list, function(folder) {
			
			this.container.grab(new Element('option', {
				'value' : folder.path,
				'text' : folder.path
			}));

		}, this);
		
		
	}
});