/**
 * Validates a given form
 */
var XValidator = new Class({

	Extends: Form.Validator.Inline,

	initialize: function(form, options) {

		options = options ? options : {};

		options.onElementFail = function(el, check) {

			check = (typeOf(check) == 'array') ? check.getLast() : check;
			var txt = el.title ? el.title : XLang.validation[check.split(':')[0]];
			el.pointer ? el.pointer.update(txt) : new Pointer(el, txt);

		};

		options.onElementPass = function(el) {
			return (el.pointer && el.pointer.hide());
		};

		options.showError = function() {};

		this.parent(form, options);
	}

});



/**
 * Validates only simple characters (a-Z, 0-9, '.', '_' & '-')
 */
Form.Validator.add('validate-simple', {
	
	test: function(el) {
		
		var regex = /^[a-zA-Z0-9._-]+$/;
		return (!el.value || regex.test(el.value));
		
	 }

});



/**
 * Validates password strength
 * TODO: 1.7 - Include password strength indication (show or return)
 */
Form.Validator.add('validate-password', {
	
	test: function(el) {

		// Special characters (prevent 'weird' password)
		var regex = /^[0-9a-zA-Z!@#$%^&*()]*$/;
		if (!regex.test(el.value)) {
			return false;
		}
		
		// Length
		var s = +(el.value.length > 5);

		// Common characters
		var regex = new Array(/[a-z]+/, /[A-Z]+/, /[0-9]+/);
		for (var i = 0; i < regex.length; i++) {
			s = (regex[i].test(el.value)) ? (s + 1) : s;
		}

		// Strenght colors (future usage)
		// new Array('#ffabab', '#ffb36e', '#ffda7a', '#fcf98c', '#b3ffab');

		return (s > 3);
	 }

});



/**
 * Validates phone numbers
 */
Form.Validator.add('validate-phone', {

	test: function(el) {

		var regex = /^[0-9\s\(\)\+\-]+$/;
		return (!el.value || regex.test(el.value));

	}

});