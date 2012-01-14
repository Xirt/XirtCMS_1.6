var XManager = new Class({

   Extends: XDefaultManager,

   showEditPanel: function() {
      new EditNodePanel(this.retrieve('id'));
   },

   showConfigPanel: function() {
      new EditConfigPanel(this.retrieve('id'));
   },

   showAccessPanel: function() {
      new AccessPanel(this.retrieve('id'));
   },

   // METHOD :: Move item down the list
   moveDown: function(event) {

      var current = next = this.getParent('tr');
      var level = current.retrieve('level');

      do {

         next = next.getNext();
         if (!next || next.retrieve('level') < level) {
            return current.highlight('#ff7979');
         }

      } while (current.retrieve('level') != next.retrieve('level'));

      new Request({
         onFailure: Xirt.showError,
         onSuccess: XManager.reload.bind(XManager),
         url: 'index.php'
      }).post({
         content: XManager.component,
         task: 'move_down',
         xid: this.retrieve('xId')
      });

   },

   // METHOD :: Move item up the list
   moveUp: function(event) {

      var current = previous = this.getParent('tr');
      var level = current.retrieve('level');

      do {

         previous = previous.getPrevious();
         if (!previous || previous.retrieve('level') < level) {
            return current.highlight('#ff7979');
         }

      } while (level != previous.retrieve('level'));

      new Request({
         onFailure: Xirt.showError,
         onSuccess: XManager.reload.bind(XManager),
         url: 'index.php'
      }).post({
         content: XManager.component,
         task: 'move_up',
         xid: this.retrieve('xId')
      });

   },

   // METHOD :: Toggles visibility for sitemap
   toggleSitemap: function() {

      var status = this.retrieve('status');
      this.store('status', status ? 0 : 1);
      this.set('opacity', status ? 0.5 : 1);

      new Request({
         onFailure: Xirt.showError,
         url: 'index.php'
      }).post({
         content: XManager.component,
         task: 'toggle_sitemap',
         id: this.retrieve('id')
      });

   }

});
window.addEvent('domready', function() {
   XManager = new XManager('adm_categories');
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
var EditNodePanel = new Class({

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



/*******************************
* Class to show 'config'-panel *
*******************************/
var EditConfigPanel = new Class({

   Extends: ManagePanel,

   // METHOD :: Initializes panel
   initialize: function(id) {

      this.panel = 'dvConfig';

      this.addEvent('populate', function(form, json) {

         Xirt.populateForm(form, json.config);
         form.affect_all.set('checked', false);

      });

      this.parent(id, {
         'width' : 810,
         'task' : 'show_details'
      });

   }

});



/*******************************
* Class to show 'access'-panel *
*******************************/
var AccessPanel = new Class({

   Extends: ManagePanel,

   // METHOD :: Initializes panel
   initialize: function(id) {

      this.panel = 'dvAccess';

      this.addEvent('finished', function() {
         XManager.reload();
      });

      this.addEvent('populate', function(form) {
         form.affect_all.set('checked', true);
      });
      
      this.parent(id, {
         'task' : 'show_details'
      });

   }

});