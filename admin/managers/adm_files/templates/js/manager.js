var XTreeViewer, XFileViewer;
var XManager = new Class({

	currentFolder: './',

	initialize: function(component) {
		this.component = component;
	},

	// METHOD :: Loads edit-form
	showEditPanel: function() {
		new EditPanel(this.retrieve('path'));
	},

	// METHOD :: Removes item
	remove: function() {

		if (confirm(XLang.confirmations['remove'])) {

			new Request({
				onFailure: Xirt.showError,
				onSuccess: this.onRemoval,
				url: 'index.php'
			}).post({
				content: 'adm_files',
				task: 'remove_item',
				path: this.retrieve('path')
			});

		}

	},
	
	onRemoval: function() {

		Xirt.showNotice(XLang.messages['removed']);
		XTreeViewer.reload();
		XFileViewer.reload();

	}

});

window.addEvent('domready', function() {

	XManager = new XManager('adm_files');
	XTreeViewer = new FileTree('box-tree');
	XFileViewer = new FileViewer('box-files');

});


/*******************************
* Class to show 'create'-panel *
*******************************/
var CreateDirectoryPanel = new Class({

	Extends: AddPanel,

	// METHOD :: Initializes panel
	initialize: function() {

		this.panel = 'dvCreate';
		
		this.addEvent('finished', function() {
			XTreeViewer.reload();
			XFileViewer.reload();
		});

		this.parent();
		this.form.path.value = XManager.currentFolder;
	}

});


/*******************************
* Class to show 'upload'-panel *
*******************************/
var UploadFilePanel = new Class({

	Extends: AddPanel,

	// Initializes panel
	initialize: function() {

		this.panel = 'dvAdd';

		this.addEvent('populate', function(form) {
			form.path.set('value', XFileViewer._path);
		});

		// Overwrite default form handling
		this.parent({ 'width' : 500 });
		this.form.removeEvents('submit');
 
		// Add upload tracking
		new XUpload({
			form: this.form,
			progressBar: 'bar-progress',
			onStart: this.onStart.bind(this),
			onFailure: this.onFailure.bind(this),
			onComplete: this.onComplete.bind(this)
		});
		
	},
	
	// Fired on upload
	onStart: function() {
		$('buttons-upload').reveal();		
	},
	
	// Fired on upload completion
	onComplete: function() {
		
		this.form.reset();
		this.window.hide();
		XFileViewer.reload();		
		$('buttons-upload').reveal();

	},
	
	// Fired on upload failure
	onFailure: function() {
		$('buttons-upload').dissolve();		
	}

});



/*****************************
* Class to show 'edit'-panel *
*****************************/
var EditPanel = new Class({

	Extends: ManagePanel,
	
	// Initializes panel
	initialize: function(path) {

		new PathList('x-path');
		this.panel = 'dvItem';
		this.path = path;

		this.addEvent('finished', function() {
			XTreeViewer.reload();
			XFileViewer.reload();
		});

		this.addEvent('populate', function(form, json) {

			$('box-permissions').hide();			
			this._parsePath(json);
			
			if (json.chmod != -1) {

				var user	  = this._getPermissions(json.chmod.charAt(0));
				var group  = this._getPermissions(json.chmod.charAt(1));
				var global = this._getPermissions(json.chmod.charAt(2));

				form.user_r.checked = user[0];
				form.user_w.checked = user[1];
				form.user_x.checked = user[2];

				form.grp_r.checked = group[0];
				form.grp_w.checked = group[1];
				form.grp_x.checked = group[2];

				form.glob_r.checked = global[0];
				form.glob_w.checked = global[1];
				form.glob_x.checked = global[2];

				$('box-permissions').show();

			}
		
		});
		
		this.parent(0, { 'width' : 500 } );

	},

	// Loads edit-form
	_load: function() {

		new Request.JSON({
			onFailure: Xirt.showError,
			onSuccess: this._receive.bind(this),
			url: 'index.php'
		}).post({
			content: XManager.component,
			task: 'show_item',
			path: this.path
		});

	},

	// Adds all returned paths to the form
	_parsePath: function(json) {

		var path	   = [];
		var looping = true;
		var paths	= json.path.split('/');
		var options = this.form.x_path.options;

		if (json.type == 'folder') {
			paths.pop();
		}
		
		while (paths.length && looping) {
			
			paths.pop();
			path = paths.join('/') + '/';

			Object.every(options, function(option) {

				if (options == path) {
					
					this.form.x_path.set('value', path);
					return (looping = false);

				}
				
				return true;
			}, this);

		}

		this.form.path.set('value', json.file);
	},

	// Returns permissions in usable format
	_getPermissions: function(val) {

		return [
			(val > 3),
			(val == 2 || val == 3 || val == 6 || val == 7),
			(val % 2)
		];

	}

});