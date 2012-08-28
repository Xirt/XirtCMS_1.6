function getParam(pName) {
   pName = pName.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
   var regex = new RegExp("[\\?&]" + pName + "=([^&#]*)");
   var res = regex.exec( window.location.href );
   return (res == null) ? "" : res[1];
}

var XManager = new Class({

   Extends: XDefaultManager,
   menu_id: getParam('menu_id'),

   initialize: function(component) {
      this.parent(component);

      // Link selector
      $('x_link_type').addEvent('change',this.selectLinkType);
      $$('select[size=15]').each(function(el) {
         el.addEvent('click', this.selectLink);
      }.bind(this));

   },

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
         xid: this.retrieve('xId'),
         menu_id: XManager.menu_id
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
         xid: this.retrieve('xId'),
         menu_id: XManager.menu_id
      });

   },

   // METHOD :: Sets home status for current item
   toggleHome: function() {

   	new Request({
         onFailure: Xirt.showError,
         onSuccess: XManager.reload.bind(XManager),
         url: 'index.php'
      }).post({
         content: XManager.component,
         task: 'toggle_home',
         xid: this.retrieve('xId')
      });
   	
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
         content: XManager.component,
         task: 'toggle_sitemap',
         id: this.retrieve('id')
      });

   },

   // METHOD :: Switch the currently selected link type
   selectLinkType: function() {

      var value = this.value;

      $$('select[size=15]').each(function(el) {
      	
      	el = $(el);
      	var id = el.get('id');
      	(id.substr(id.length - 1) != value) ? el.hide() : el.show();

      });

   },

   // METHOD :: Switch the currently selected link
   selectLink: function() {

      var nVal = this.value;
      $('x_link').value = nVal;

      $$('select[size=15] option').each(function(cEl) {
         if (cEl.value != nVal) {
            cEl.selected = false;
         }
      });

   }

});
window.addEvent('domready', function() {
   XManager = new XManager('adm_menueditor');
   XManager.load();
});



/****************************
* Class to show 'add'-panel *
****************************/
var AddPanel = new Class({

   Extends: AddPanel,

   // Initializes panel
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

   // Initializes panel
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

   // Initializes panel
   initialize: function(id) {

      this.panel = 'dvConfig';

      this.addEvent('populate', function(form, data) {

         form.x_links_0.value = data.link;
         form.x_links_1.value = data.link;
         form.x_links_2.value = data.link;
         form.affect_all.checked = true;

         $('x_link_type').fireEvent('change');

      });

      this.parent(id, {
         'width' : 840,
         'task' : 'show_details'
      });

   }

});



/*******************************
* Class to show 'access'-panel *
*******************************/
var AccessPanel = new Class({

   Extends: ManagePanel,

   // Initializes panel
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