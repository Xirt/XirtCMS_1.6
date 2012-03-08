var XManager = new Class({

	Extends: XDefaultManager,

	// METHOD :: Loads edit-form
	showEditForm: function() {
		new EditPanel(this.retrieve('id'));
	},

	// METHOD :: Loads password-form
	showPasswordForm: function() {
		new PasswordPanel(this.retrieve('id'));
	},
	
	// METHOD :: Removes item
	remove: function() {

		if (confirm(XLang.confirmations['remove'])) {

			new Request({
				onFailure: Xirt.showError,
				onSuccess: XManager.removeCompleted,
				url: 'index.php'
			}).post({
				content: 'adm_users',
				task: 'remove_item',
				id: this.retrieve('id')
			});

		}

	},

	// METHOD :: Shows removal completion
	removeCompleted: function(transport) {

		if (transport) {
			Xirt.showNotice(transport);
			return false;
		}

		XManager.reload();

	}

});

window.addEvent('domready', function() {
	XManager = new XManager('adm_users');
	XManager.load();
});



/****************************
* Class to show 'add'-panel *
****************************/
var AddPanel = new Class({

	Extends: AddPanel,

	// METHOD :: Initializes panel
	initialize: function() {

		this.panel = 'dvAdd';
		this.addEvent('finished', function() {
			XManager.reload();
		});

		this.parent();
	}

});



/*****************************
* Class to show 'edit'-panel *
*****************************/
var EditPanel = new Class({

	Extends: ManagePanel,

	// METHOD :: Initializes panel
	initialize: function(id) {

		this.panel = 'dvItem';

		this.addEvent('populate', function() {
			this.form.x_rank.disabled = (this.id == '1');
		});

		this.addEvent('finished', function() {
			XManager.reload();
		});

		this.parent(id);
	}

});



/*********************************
* Class to show 'password'-panel *
*********************************/
var PasswordPanel = new Class({

	Extends: ManagePanel,

	// Initializes panel
	initialize: function(id) {

		this.panel = 'dvPassword';
		this.parent(id);

		// Activate toggler
		$('randomizer').removeEvents('click');
		$('randomizer').addEvent('click', this.toggleCustomizer);
		$('randomizer').fireEvent('click');

	},
	
	toggleCustomizer: function() {

		Xirt.hideTooltips();
		var el = $('custom-password');
		($('randomizer').checked ? el.hide() : el.show());

	},
	
	// Message to show on finish
	_finished: function(output) {

		Xirt.showNotice(output);
		this.fireEvent('onFinished');
		this.hide();

	}

});