var XManager = new Class({

	Extends: XDefaultManager,

	// Loads 'entry'-panel
   showEntryPanel: function() {
      new EntryPanel(this.retrieve('id'));
   },

   showLogPanel: function() {
      new LogPanel();
   },
	
	// Removes item
	remove: function() {

		if (confirm(XLang.confirmations['remove'])) {

			new Request({
				onFailure: Xirt.showError,
				onSuccess: XManager.removeCompleted,
				url: 'index.php'
			}).post({
				content: this.component,
				task: 'remove_item',
				id: this.retrieve('id')
			});

		}

	},

	// METHOD :: Shows removal completion
	removeCompleted: function(transport) {
		XManager.reload();
	},

   clearLog: function(type) {

      new Request({
         onFailure: Xirt.showError,
         onSuccess: XManager.refresh,
         url: 'index.php'
      }).post({
         content: XManager.component,
         task: 'clear_errors',
         log: type
      });

   },

   clearNotification: function() {

      new Request({
         onFailure: Xirt.showError,
         onSuccess: XManager.refresh,
         url: 'index.php'
      }).post({
         content: XManager.component,
         task: 'reset_notification'
      });

   },

   refresh: function() {
      document.location.href = document.location.href;
   }

});
window.addEvent('domready', function() {
	XManager = new XManager('adm_portal');
	XManager.load();
});



/******************************
* Class to show 'entry'-panel *
******************************/
var EntryPanel = new Class({

	Extends: ManagePanel,

	// Initializes panel
	initialize: function(id) {

		this.panel = 'dvItem';
		this.parent(id, { 'width' : 750 });

	}

});



/*******************************
* Class to show 'log'-panel *
*******************************/
var LogPanel = new Class({

   Implements: [Events],

   // Initializes panel
   initialize: function() {
      this._load();
   },

   // Loads error log
   _load: function() {

      new Request({
         onFailure: Xirt.showError,
         onSuccess: this._receive.bind(this),
         url: 'index.php'
      }).post({
         content: XManager.component,
         task: 'show_log'
      });

   },

   // Shows error log in panel
   _receive: function(transport) {
      new Window(transport, 800).show();
   }

});