var XManager = new Class({

   Extends: XDefaultManager,

   // METHOD :: Initializes manager
   initialize: function(component) {

      this.parent(component);
      $('pages').ms = new MultipleSelect($('pages'));

      // Form behavior: adding
      $('button_add').addEvent('click', function() {

         var el = $('nx_position');
         var position = el.get('value');

         if ((position = position.trim()) && position && el.set('value', '')) {

            $('positions').grab(new Element('option', {
               'value': position,
               'text': position
            }));

         }

      });

      // Form behavior: removing
      $('button_rem').addEvent('click', function() {

         $('positions').getSelected().each(function(el) {
            el.dispose();
         });

      });

   },

   // METHOD :: Loads edit-form
   showEditForm: function() {
      new EditPanel(this.retrieve('id'));
   },

   // METHOD :: Loads edit-form
   showConfigForm: function() {
      new ConfigPanel(this.retrieve('id'));
   },

   // METHOD :: Toggles status (published / unpublished)
   toggleStatus: function() {

      var el = this.getParent('tr');
      if (!el.getPrevious()) {
         return el.highlight('#ff7979');
      }

      new Request({
         onFailure: Xirt.showError,
         onSuccess: XManager.reload.bind(XManager),
         url: 'index.php'
      }).post({
         content: 'adm_templates',
         task: 'toggle_status',
         id: this.retrieve('id')
      });

   },

   // METHOD :: Toggles status (published / unpublished)
   toggleActive: function() {

      var el = this.getParent('tr');
      if (!el.getPrevious()) {
         return el.highlight('#92ff79');
      }

      new Request({
         onFailure: Xirt.showError,
         onSuccess: XManager.activeCompleted,
         url: 'index.php'
      }).post({
         content: 'adm_templates',
         task: 'toggle_active',
         id: this.retrieve('id')
      });

   },

   // METHOD :: Removes item
   remove: function() {

      if (confirm(XLang.confirmRemove)) {

         new Request({
            onFailure: Xirt.showError,
            onSuccess: XManager.removeCompleted,
            url: 'index.php'
         }).post({
            content: 'adm_templates',
            task: 'remove_item',
            id: this.retrieve('id')
         });

      }

   },

   // METHOD :: Shows activation completion
   activeCompleted: function() {

      Xirt.showNotice(XLang.mSuccess);
      XManager.reload();

   },

   // METHOD :: Shows removal completion
   removeCompleted: function(transport) {

      if ((transport = transport.trim()) && transport) {
         return Xirt.showNotice(transport);
      }

      Xirt.showNotice(XLang.mRemoved);
      XManager.reload();

   }

});
window.addEvent('domready', function() {
   XManager = new XManager('adm_templates');
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

      this.addEvent('populate', function(form, json) {

         var pages = json.pages.split('|');
         Array.each(form.pages, function(el) {

            el.set('selected', false);
            if (pages.contains(el.get('value'))) {
               el.set('selected', true);
            }

         });

         form.pages.ms.update();

      });

      this.addEvent('save', function(form) {

         var pages = new Array();
         form.pages.getSelected().each(function(el) {

            if (el.get('value').charAt(0) != '-') {
               pages[pages.length] = el.get('value');
            }

         });

         form.x_pages.set('value', pages.join('|'));

      });

      this.addEvent('finished', function() {
         XManager.reload();
      });

      this.parent(id, { 'width' : 525 });
   }

});



/*****************************
* Class to show 'edit'-panel *
*****************************/
var ConfigPanel = new Class({

   Extends: ManagePanel,

   // METHOD :: Initializes panel
   initialize: function(id) {

      this.panel = 'dvConfig';

      this.addEvent('populate', function(form, json) {

         var positions = $(form.positions).empty();
         Array.each(json.positions.split('|'), function(position) {

            if ((position = position.trim()) && position) {

               positions.grab(new Element('option', {
                  value: position,
                  text: position
               }));

            }

         });

      });

      this.addEvent('save', function(form) {

         var positions = new Array();
         Array.each(form.positions, function(el, key) {
            positions[key] = el.get('value');
         });

         form.x_positions.set('value', positions.join('|'));

      });

      this.addEvent('finished', function() {
         XManager.reload();
      });

      this.parent(id, { 'width' : 550 });
   }

});
