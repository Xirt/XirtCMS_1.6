var ModContact = new Class({

	initialize : function(element) {

		this.form     = element;
		this.buttons  = this.form.getElement('.box-buttons');
		this.fieldset = this.form.getElement('.box-contact');
 
		new XValidator(this.form, {
			onFormValidate: this._onSubmit.bind(this)
		});

	},

	// Submits data of panel
	_onSubmit: function(validateOutput, el, event) {

		event.stop();

		if (validateOutput) {

			new Request.Form(this.form, {
				onSuccess: this._sendComplete.bind(this),
				onRequest: this._sendProgress.bind(this)
			}).send();

		}
		
	},

	// Shows progress
	_sendProgress: function() {

		this.fieldset.set('html', XLang.messages['process']);
		
		// Hide buttons
		this.buttons.dissolve();
		Array.each(this.buttons.getElements('button'), function(el) {
			el.set('disabled', 'disabled');
		});

	},

	// Shows the result 
	_sendComplete: function(transport) {
		this.fieldset.set('html', transport);
	}

});

window.addEvent('domready', function() {

	Array.each($$('.x-mod-contact-form'), function(el) {
		new ModContact(el);
	});

});