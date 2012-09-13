var XAdmin = {

	indent: function(l, postfix) {
		
		var str = '';
		var c = '\u00a0';

		for (var i = 0; i < l; i++) {
			str = str + c;
		}

		return postfix ? str + postfix : str;		
	},

	elipsis: function(str, l) {

		if (str.length > l) {
			return str.substr(0, l) + '...';
		}

		return str;
	},

	createId: function(id) {
		return ("000000" + id).slice(-6);
	},

	createIdent: function(l, postfix) {
		Xirt.showNotice("Deprecated use of XAdmin.indent().");
		XAdmin.indent(l, postfix);
	},

	threeDots: function(str, l) {
		Xirt.showNotice("Deprecated use of XAdmin.threeDots().");
		XAdmin.elipsis(str, l);
	},

	resetForms: function() {
		Xirt.showNotice("Deprecated use of XAdmin.indent().");
		Forms.reset();
	}
	
};



/**
* XDefaultManager - Class with some common management methods
* TODO: Rename & move to XList (not used elsewhere)
*/
var XDefaultManager = new Class({

	component: null,
	language: null,
	_content: null,

	// Initializes manager
	initialize: function(component) {
		this.component = component;
	},

	// Creates and load the current list
	load: function() {
		this._content = new ContentList(this.component);	
		this._content.load();		
	},

	// Reloads the current xList
	reload: function() {
		this._content ? this._content.reload() : [];
	},

	// Adds translations
	addTranslation: function() {

		new Request({
			onFailure: Xirt.showError,
			onSuccess: XManager.reload.bind(XManager),
			url: 'index.php'
		}).post({
			content: XManager.component,
			task: 'add_translation',
			language: XManager.language,
			xid: this.retrieve('xId')
		});

	},

	// Toggles status (mobile on / off)
	toggleMobile: function() {

		var status = this.retrieve('status');
		this.store('status', status ? 0 : 1);
		this.setStyle('opacity', status ? 0.5 : 1);

		new Request({
			onFailure: Xirt.showError,
			url: 'index.php'
	  }).post({
			content: XManager.component,
			task: 'toggle_mobile',
			id: this.retrieve('id')
		});

	},

	// Toggles status (published / unpublished)
	toggleStatus: function() {

		var oStatus = this.retrieve('status');
		var status = oStatus ? 0 : 1;

		this.store('status', status);
		this.setProperty('src', this.getProperty('src').replace(
			'published_' + oStatus,
			'published_' + status
			)
		);

		new Request({
			onFailure: Xirt.showError,
			url: 'index.php'
		}).post({
			content: XManager.component,
			task: 'toggle_status',
			id: this.retrieve('id')
		});

	},

	// Removes translation
	removeTranslation: function(event) {

		if (!confirm(XLang.confirmations['remove'])) {
			return;
		}

		new Request({
			onFailure: Xirt.showError,
			onSuccess: XManager.reload.bind(XManager),
			url: 'index.php'
		}).post({
			content: XManager.component,
			task: 'remove_translation',
			xid: this.retrieve('xId'),
			id: this.retrieve('id')
		});

	}
});



var AddPanel = new Class({

	Implements: [Events, Options],

	options: {
		width: 400
	},

	// Initializes panel
	initialize: function(options) {

		this.setOptions(options);
	   this._prepare();
		this.show();

	},
	
	_prepare: function() {
		
		this.element = $(this.panel);
		this.form    = this.element.getElement('form');

		this._validation();

		if (!(this.window = XRegister.isRegistered(this.panel)) || !this.window) {
			this.window = new Window(this.element.show(), this.options.width);
			//this.window.id = this.panel;
		}
		
		this.fireEvent('onPopulate', [this.form]);

	},

	// Add validation to the panel
	_validation: function() {

		var validator = new XValidator(this.form, {
			onFormValidate: this._save.bind(this)
		});

		this.form.removeEvents();
		this.form.addEvent('submit', validator.validate.bind(validator));

	},

	// Submits data of panel
	_save: function(validateOutput, el, event) {

		if (validateOutput) {

			new Request.Form(this.form, {
				onFailure: XAdmin.showError,
				onSuccess: this._finished.bind(this)
			}).send();

		}

		event.stop();

	},

	// Hides the panel after transfer
	_finished: function(output) {

		if (output && output.length) {
			return Xirt.showNotice(output);
		}

		this.hide();
		this.fireEvent('onFinished');
		Xirt.showNotice(XLang.messages['success']);

	},

	// Shows the panel
	show: function() {
		
		this.window.show();
		this.fireEvent('onShow');
		
	},

	// Hides the panel
	hide: function() {

		Forms.reset();
		this.fireEvent('onHide');
		this.window.hide();

	}

});



var ManagePanel = new Class({

	Extends: AddPanel,

	options: {
		id: null,
		width: 400,
		task: 'show_item'
	},

	// Initializes panel
	initialize: function(id, options) {

		this.setOptions(options);
	   this._prepare();
	   
		if ((this.id = id) && this.id) {
	      this._load();
      }

	},

	// Add validation to the panel
	_validation: function() {

		var validator = new XValidator(this.form, {
			onFormValidate: this._save.bind(this)
		});

		this.form.removeEvents();
		this.form.addEvent('submit', validator.validate.bind(validator));

	},

	// Loads data of panel
	_load: function() {

		new Request.JSON({
			onFailure: function(a) {alert(a);},
			onSuccess: this._receive.bind(this),
			url: 'index.php'
		}).post({
			content: XManager.component,
			task: this.options.task,
			id: this.id
		});

	},

	// Shows panel with returned data
	_receive: function(json) {

		if (typeOf(json) == 'String') {
			Xirt.showNotice(json);
			return false;
		}

		Xirt.populateForm(this.form, json);
		this.fireEvent('onPopulate', [this.form, json]);
		this.show();

	},

	// Submits data of panel
	_save: function(validateOutput, el, event) {

		event.stop();

		if (validateOutput) {

			this.fireEvent('onSave', [this.form]);

			new Request.Form(this.form, {
				onFailure: XAdmin.showError,
				onSuccess: this._finished.bind(this)
			}).send();

		}

	}

});