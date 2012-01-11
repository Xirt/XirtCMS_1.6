var XManager = new Class({

   Extends: XDefaultManager,

   // METHOD :: Loads edit-form
   showEditForm: function() {

      new EditPanel(this.retrieve('id'));

   },

   // METHOD :: Removes item
   remove: function() {

      if (confirm(XLang.confirmations['remove'])) {

         new Request({
            onFailure: Xirt.showError,
            onSuccess: XManager.reload.bind(XManager),
            url: 'index.php'
         }).post({
            content: 'com_search',
            task: 'remove_item',
            id: this.retrieve('id')
         });

      }

   }

});

window.addEvent('domready', function() {
   XManager = new XManager('com_search');
   XManager.load();
});



/****************************
* Class to show 'add'-panel *
****************************/
var AddPanel = new Class({

   Extends: AddPanel,

   initialize: function() {

      this.panel = 'dvAdd';

      this.addEvent('populate', function(form) {
         form.nx_language.set('value', XManager.iso);
      });

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

      this.addEvent('finished', function() {
         XManager.reload();
      });

      this.parent(id);

   }

});
