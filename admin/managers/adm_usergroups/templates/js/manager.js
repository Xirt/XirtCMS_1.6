var XManager = new Class({

   Extends: XDefaultManager,

   // METHOD :: Loads edit-form
   showEditPanel: function() {
      new EditPanel(this.retrieve('id'));
   }

});

window.addEvent('domready', function() {
   XManager = new XManager('adm_usergroups');
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

      this.addEvent('populate', function(form) {
         form.nx_language.set('value', XManager.iso);
      });

      this.addEvent('finished', function() {
         XManager.reload();
      });

      this.parent();
   }

});



/*******************************
* Class to show 'edit'-panel *
*******************************/
var EditPanel = new Class({

   Extends: ManagePanel,

   // METHOD :: Initializes panel
   initialize: function(id) {

      this.panel = 'dvItem';

      this.addEvent('populate', function(form, json) {
         form.xid.set('value', json.rank);
      });
      
      this.addEvent('finished', function() {
         XManager.reload();
      });
      
      this.parent(id);
   }

});