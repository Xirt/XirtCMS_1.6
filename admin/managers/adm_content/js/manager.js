var CKEDITOR = CKEDITOR ? CKEDITOR : null;
var XManager = new Class({

   Extends: XDefaultManager,

   _categories: [],
   language: null,

   initialize: function(component) {
      
      this.component = component;
      
      // Animate panels
      new Fx.Accordion($$('#xOptions h4'), $$('#xOptions .box-option'), {

         onActive: function(toggler, element) {
            toggler.addClass('active');
         },

         onBackground: function(toggler, element) {
            toggler.removeClass('active');
         },

         opacity: false

      });

      this.editor = new EditPanel();

   },

   load: function() {

      this._content = new ContentList(this.component);  
      
      this._categories = new CategoryList({
         onComplete: this._content.load.bind(this._content)
      });

      this._categories.load();

   },
   
   showEditPanel: function() {
      XManager.editor.load(this.retrieve('id'));
   },

   showConfigPanel: function() {
      new ConfigPanel(this.retrieve('id'));
   },

   showAccessPanel: function() {
      new AccessPanel(this.retrieve('id'));
   }

});

window.addEvent('domready', function() {
   XManager = new XManager('adm_content');
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
   initialize: function(options) {

      this.panel     = 'dvItem';
      this.element   = $(this.panel);
      this.window    = this.element;
      this.form      = this.element.getElement('form');
      this.hasEditor = !!CKEDITOR;
      this.jsEditor  = this.hasEditor ? CKEDITOR.instances.x_content : null;
      this.rawEditor = this.hasEditor ? null : $('x_content');
      this.setOptions(options);
      this._validation();
      
      $('xClose').addEvent('click', function() {

         Xirt.hideTooltips();
         this.element.hide();

      }.bind(this));

      this.addEvent('populate', function(form, json) {

         if (this.hasEditor) {

            //this.jsEditor.setReadOnly(false);
            this.jsEditor.setData(json.content);

         } else {
            
            this.rawEditor.set('disabled', false);
            
         }

      });

      this.addEvent('show', function() {      
         window.fireEvent('resize');
      });

      this.addEvent('save', function(form, json) {

         if (this.hasEditor) {

            this.jsEditor.updateElement();
            //this.jsEditor.setReadOnly(true);

         }

      });

      this.addEvent('finished', function() {
         XManager.reload();
      });

      window.addEvent('resize', this.resize.bind(this));
      this.element.inject(document.body);

   },
   
   load: function(id) {
      
      this.id = id;

      if (this.hasEditor) {
      
         this.jsEditor.setData(XLang.messages['loading']);
         //this.jsEditor.setReadOnly(true);

      } else {

         this.rawEditor.set('disabled', true);

      }
      
      this.window.show();
      window.fireEvent('resize');

      this._load();

   },

   // METHOD :: Resizes edit-form
   resize: function() {

      var dimensions = window.getSize();

      if (this.hasEditor) {
         
         this.jsEditor.resize(dimensions.x - 500, dimensions.y - 125);

      } else {
         
         this.rawEditor.setStyle('height', dimensions.y - 125);
         this.rawEditor.setStyle('width', dimensions.x - 515);
         
      }

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

         Xirt.populateForm(form, json.config);
         form.affect_all.set('checked', false);

      });

      this.parent(id, { 'task' : 'show_details' });

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

      this.parent(id, { 'task' : 'show_details' });

   }

});
