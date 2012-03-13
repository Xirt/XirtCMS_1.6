var XManager = new Class({

   Extends: XDefaultManager,

   // METHOD :: Initializes manager
   initialize: function(component) {

      this.parent(component);
      $('pages').ms = new MultipleSelect($('pages'));

   },

   showEditPanel: function() {
      new EditPanel(this.retrieve('id'));
   },

   showConfigPanel: function() {
      new ConfigPanel(this.retrieve('id'));
   },

   showAccessPanel: function() {
      new AccessPanel(this.retrieve('id'));
   }

});
window.addEvent('domready', function() {
   XManager = new XManager('adm_modules');
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

      this.addEvent('populate', function(form, json) {

         form.affect_all.set('checked', false);

         var container = $('configuration').empty();
         Object.every(json.config, function(data, key) {

            switch (data.type) {

               case 'text':
                  this.addTextField(data, container);
               break;

               case 'select':
                  this.addSelectField(data, container);
               break;

            }

            return true;
         }, this);

      }, this);

      this.parent(id, { 'task' : 'show_details' });
   },

   addTextField: function(data, container) {

      new Element('label', {
         'for' : 'xvar_' + data.name,
         'text' : data.label
      }).inject(container);

      new Element('input', {
         'type' : 'text',
         'name' : 'xvar_' + data.name,
         'value' : data.value
      }).inject(container);

   },

   addSelectField: function(data, container) {

      new Element('label', {
         'for' : 'xvar_' + data.name,
         'text' : data.label
      }).inject(container);

      var el = new Element('select', {
         'name' : 'xvar_' + data.name
      }).inject(container);

      Object.every(data.options, function(value, setting) {

         return new Element('option', {
            'text' : setting,
            'value' : value
         }).inject(el);

      }, this);

      el.set('value', data.value);
   }

});



/*******************************
* Class to show 'config'-panel *
*******************************/
var ConfigPanel = new Class({

   Extends: ManagePanel,

   // METHOD :: Initializes panel
   initialize: function(id) {

      this.panel = 'dvConfig';

      this.addEvent('finished', function() {
         XManager.reload();
      });

      this.addEvent('populate', function(form, json) {

         var pages = json.pages.split('|');
         Array.each(form.pages, function(el) {

            el = $(el);
         	el.set('selected', false);

         	if (pages.contains(el.get('value'))) {
               el.set('selected', true);
            }

         });

         form.pages.ms.update();

      });

      this.addEvent('save', function(form, json) {

         var pages = new Array();
         Array.each(form.pages.getSelected(), function(el) {

            if (el.get('value').charAt(0) != '-') {
               pages.push(el.get('value'));
            }

         });

         form.x_pages.set('value', '|' + pages.join('|') + '|');
      });

      this.parent(id, { 'width' : 525 });

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

      this.addEvent('populate', function(form, data) {
         form.affect_all.checked = true;
      });

      this.addEvent('finished', function() {
          XManager.reload();
       });
      
      this.parent(id);
   }

});