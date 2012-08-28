var XManager = new Class({

   Extends: XDefaultManager,

   // METHOD :: Loads edit-form
   showEditPanel: function() {
      new EditPanel(this.retrieve('id'));
   },

   // METHOD :: Continues to the Menu Editor (administration)
   goContent: function() {

      var link = 'index.php?content=adm_menueditor&menu_id=';
      document.location.href = link + this.retrieve('xId');

   },

   // METHOD :: Move item down the list
   moveDown: function(event) {

      var el = this.getParent('tr');
      if (!el.getNext()) {
         return el.highlight('#ff7979');
      }

      new Request({
         onFailure: Xirt.showError,
         url: 'index.php'
      }).post({
         content: XManager.component,
         task: 'move_down',
         xid: this.retrieve('xId')
      });

      el.inject(el.getNext(), 'after');
   },

   // METHOD :: Move item up the list
   moveUp: function(event) {

      var el = this.getParent('tr');
      if (!el.getPrevious()) {
         return el.highlight('#ff7979');
      }

      new Request({
         onFailure: Xirt.showError,
         url: 'index.php'
      }).post({
         content: XManager.component,
         task: 'move_up',
         xid: this.retrieve('xId')
      });

      el.inject(el.getPrevious(), 'before');
   },

   // METHOD :: Toggles visibility for sitemap
   toggleSitemap: function() {

      var status = this.retrieve('status');
      this.store('status', status ? 0 : 1);
      this.setStyle('opacity', status ? 0.5 : 1);

      new Request({
         onFailure: Xirt.showError,
         url: 'index.php'
      }).post({
         content: 'adm_menus',
         task: 'toggle_sitemap',
         id: this.retrieve('id')
      });

   }

});
window.addEvent('domready', function() {
   XManager = new XManager('adm_menus');
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

      this.addEvent('finished', function() {
         XManager.reload();
      });

      this.parent(id);

   }

});
