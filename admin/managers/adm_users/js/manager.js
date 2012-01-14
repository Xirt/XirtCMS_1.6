var XManager = new Class({

   Extends: XDefaultManager,

   // METHOD :: Loads edit-form
   showEditForm: function() {
      new EditPanel(this.retrieve('id'));
   },

   // METHOD :: Resets password of user
   resetPassword: function() {

      if (confirm(XLang.confirmations['reset'])) {

         new Request({
            onFailure: Xirt.showError,
            onSuccess: XManager.resetCompleted,
            url: 'index.php'
         }).post({
            content: 'adm_users',
            task: 'reset_password',
            id: this.retrieve('id')
         });

      }

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

   // METHOD :: Shows reset completion
   resetCompleted: function(transport) {
      Xirt.showNotice(transport);
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