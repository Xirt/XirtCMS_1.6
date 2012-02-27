var XUpload = new Class({

	Implements: [Events, Options],

	ID_KEY : 'APC_UPLOAD_PROGRESS',
	options : {
		delay : 5
	},

	initialize : function(options) {

		if ((this.form = $(options.form)) && !this.form) {
			return false;
		}

		this.setOptions(options);
		this._setProgressBar();
		this._setTarget();
		this._setAPC();

		this.form.addEvent('submit', this._onSubmit.bind(this));
	},

	// Sets the progress bar for tracking
	_setProgressBar: function() {

		if (!$(this.options.progressBar)) {
			this.options.progressBar = new Element('div');
		}

	},

	// Sets the (invisible) target of the form
	_setTarget: function() {

		if (!this.form.target) {

			var targetFrame = Number.random(0, 1000);
			this.form.target = targetFrame;

			new Element('iframe', {
				name: targetFrame
			}).hide().inject(this.form);

		}

	},

	// Sets the (invisible) APC-ID element for the form
	_setAPC: function() {

		if (!this.form[this.ID_KEY]) {

			this.apc = new Element('input', {
				name : this.ID_KEY,
				type : 'hidden'
			}).inject(this.form, 'top');

		}

		this.apc = Number.random(0, 9999);
		this.form[this.ID_KEY].value = this.apc;

	},

	// Starts tracking the upload procedure
	_onSubmit : function(event) {

		this.progressBar = new Fx.XProgressBar(this.options.progressBar);

		if (this.options.progressBar) {
			this.progressBar.start(0);
		}

		this.fireEvent('start');
		this._retrieve();
	},

	// Retrieves the current upload status (request)
	_retrieve : function() {

		new Request.JSON({
			url: 'index.php',
			onFailure: Xirt.showError,
			onSuccess: this._receive.bind(this)
		}).post({
			content: 'adm_helper',
			task: 'show_upload_progress',
			id: this.apc
		});

	},

	// Receives the current upload status (receival)
	_receive: function(json) {

		this.progressBar.set(json.percent);

		// STATUS: Uploading
		if (!json.finished) {
			this._retrieve.delay(this.options.delay, this, json.id);
			return this.fireEvent('update');
		}

		// STATUS: Failure
		if (json.error) {
			this.progressBar.hide();
			Xirt.showNotice(json.error);
			return this.fireEvent('failure');
		}

		// STATUS: Finished
		this.progressBar.hide();
		Xirt.showNotice(XLang.messages['success']);
		return this.fireEvent('complete');
	}

});



/**
 * Class that shows / updates a progressbar
 *
 * @see XUpload
 */
Fx.XProgressBar = new Class({

	Extends: Fx,

	options: {
		transition: Fx.Transitions.Circ.easeOut,
		topClass: 'xProgressBox',
		barClass: 'xProgressBar'
	},

	initialize: function(element, options) {

		// Prepare element
		this.setOptions(options);
		var topClass = this.options.topClass;
		var barClass = this.options.barClass;

		this.container = $(element).hide();
		this.container.addClass(topClass);

		// Create loading bar
		if ((this.bar = this.container.getElement(barClass)) || !this.bar) {

			this.bar = new Element('div', {
				'class' : barClass
			}).inject(this.container);

		}

		this.parent(options);
	},

	// Start / shows the progressbar
	start: function() {

		this.set(0);
		this.show();

	},

	// Update the bar to the given percentage
	set: function(percentage) {

		var width = this.container.getComputedSize({ 'styles' : [] }).width / 100;
		this.bar.setStyle('width', Math.round(percentage * width) + 'px');
		this.now = percentage;

	},

	// Shows the bar
	show: function() {
		this.container.reveal();
	},

	// Hides the bar
	hide: function() {
		this.container.dissolve();
	}

});