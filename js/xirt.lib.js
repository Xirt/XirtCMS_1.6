/**
 * Various XirtCMS elements
 */
var XTypes = {

   Tooltip : 0,
   Window : 1,
   Message : 2

};



/**
 * Xirt main class
 */
var Xirt = new Class({

   initialize : function() {

      this._analyse();
      this._statistics();
      this._notifications();

      // Check for (old) browser version
      if ((Browser.version < 6 && Browser.ie) || 
          (Browser.firefox && Browser.version < 4)) {
         Asset.javascript('js/xupdate.js');
      }
      
   },

   // Analyses elements
   _analyse : function() {

      $$('a[rel^=external]').each(function(el) {

         el.setProperty('target', '_blank');
         el.addClass('external');

      });

   },

   // Enables Roar-notifications
   _notifications : function() {

      this.roar = new Roar({
         position : 'upperRight'
      });

   },

   // Optional statistics
   _statistics : function() {

      var container = $('xStatsBox');
      if (typeOf(container) == 'element') {

         container.addEvent('click', function() {
            this.fade();
         });

      }

   },

   /*******************
    * MESSAGE RELATED *
    ******************/
   // Shows a new window (popup)
   showWindow : function(content, w) {
      return new Window(content, w);
   },

   // Shows an alert (centered)
   showMessage : function(txt) {
      new Message(txt);
   },

   // METHOD: Show a notice
   showNotice : function(msg) {
      Xirt.roar.alert(XLang.messages['system'], msg);
   },

   // METHOD: Show an (AJAX) error
   showError : function() {
      Xirt.roar.alert(XLang.messages['system'], Xlang.errors['communication']);
   },

   // METHOD :: Show a tooltip
   showTooltip : function(el, txt) {
      new Tooltip(el, txt);
   },

   // METHOD: Hides all tooltips
   hideTooltips : function() {

      Array.each(XRegister.toArray(XTypes.Tooltip), function(item) {
         item.hide();
      });

   },

   // METHOD: Hides all tooltips (deprecated)
   hideAllTooltips : function() {

      Xirt.showNotify("Deprecated use of Xirt.hideAllTooltips();");
      this.hideTooltips();

   },

   /*****************
    * MISCELLANEOUS *
    ****************/
   // METHOD :: Populates field of a form with values given
   populateForm : function(form, data) {

      Object.every(data, function(value, key) {

         var element = form.getElement('[name=x_' + key + ']');
         if (typeOf(element) == 'element') {
            return element.set('value', value);
         }

         var element = form.getElement('[name=' + key + ']');
         if (typeOf(element) == 'element') {
            return element.set('value', value);
         }

         return true;
      }, this);

   }

});



/**
 * Register for active XirtCMS elements
 */
var XRegister = new Class({

   _storage : [],

   // Registers item
   add : function(item) {
      this._storage[this._storage.length] = item;
   },

   // Unregisters item
   remove : function(item) {
      this._storage.erase(item);
   },

   // Checks whether an item is registered
   isRegistered : function(id) {

      var list = Array.filter(this._storage, function(item) {
         return (item.id == id);
      });
      
      return list.length ? list[0] : null;
   },

   // Returns registered items
   toArray : function(type) {

      return Array.filter(this._storage, function(item) {
         return (item.type == type);
      }, this);

   }

});

window.addEvent('domready', function() {

   Xirt = new Xirt();
   XRegister = new XRegister();

});



/**
 * Creates a window (popup) with given content
 */
var Window = new Class({

   Implements : [ Options, Events ],

   type : XTypes.Window,
   options : {
      'width' : 750
   },

   initialize : function(content, w) {

      this.fog = new Fog();

      this._create(w);
      this._register();
      this.set(content);

   },

   // Sets the content
   set : function(content) {

      if (typeof (content) != 'string') {
         this.content.grab(content);
      } else {

         var box = new Element('div', {
            'class' : 'box-buttons'
         });

         box.grab(new Element('button', {
            'class' : 'close xButton',
            'text' : XLang.misc['close']
         }));

         this.content.set('html', content);
         this.element.grab(box);

      }

      Array.each(this.element.getElements('.close'), function(el) {
         el.addEvent('click', this.hide.bind(this));
      }, this);

   },

   // Registers the element
   _register : function() {

      XRegister.add(this);
      window.addEvent('resize', this._reposition.bind(this));

      if (Browser.ie) {
         window.addEvent('scroll', this._reposition.bind(this));
      }

   },

   // Positions the element
   _position : function() {

      this.element.position({
         relativeTo : $(document.body),
         ignoreScroll : true,
         relFixedPosition : Browser.ie ? true : false,
         position : 'centerTop',
         edge : 'centerTop'
      });

      // Note: IE7+ requires 'standards mode'
      this.element.setStyle('position', 'fixed');

   },

   // Shows the window
   show : function() {

      this.fog.show();
      Xirt.hideTooltips();
      this.element.reveal();

   },

   // Hides the window
   hide : function() {

      this.element.dissolve();
      Xirt.hideTooltips();
      this.fog.hide();

   },

   // Remove window (completely)
   removeWindow : function(window) {

      Xirt.showNotify("Deprecated use of Window.removeWindow()");

      window = $(window);
      if (!window || !window.isVisible()) {
         return false;
      }

      // unregister
      Xirt.window.dispose();

   },

   // METHOD :: Resizes windows after a window resize
   _reposition : function() {

      if (this.element.isVisible()) {
         this._position();
      }

   },

   // METHOD :: Creates pop-up if not available
   _create : function(w) {

      this.element = new Element('div', {
         'class' : 'xirt-window'
      }).setStyles({
         'width' : w ? w : 750 + 'px'
      }).inject(document.body).hide();

      this.content = new Element('div', {
         'class' : 'xirt-content'
      }).setStyles({
         'max-height' : Math.max(window.getSize().y - 75, 250) + 'px'
      }).inject(this.element);

      this._position();

   }

});



/**
 * Creates a tooltip next to an element (right side)
 */
var Tooltip = new Class({

   Implements : [ Options ],

   type : XTypes.Tooltip,

   initialize : function(el, txt, options) {

      this.setOptions(options);

      this._create(txt);
      this._attach(el);
      this._register();
      this.show();

   },

   // Creates the tooltip
   _create : function(txt) {

      this.element = new Element('div', {
         'class' : 'xirt-tooltip'
      }).fade('out');

      this.set(txt);
      this.element.inject($(document.body));

   },

   // (Re-sets) text of the tooltip
   set : function(txt) {

      new Element('p', {
         'text' : txt
      }).inject(this.element.empty());

   },

   // Attach tooltip to element
   _attach : function(el) {

      el.tooltip = this;
      this.container = el;

      this.element.position({
         relativeTo : el,
         position : 'centerRight',
         edge : 'centerLeft',
         offset : {
            x : +4,
            y : el.getScroll().y
         }
      });

   },

   // Registers the tooltip
   _register : function() {
      XRegister.add(this);
   },

   // Shows the tooltip
   show : function(label) {

      if (label && label.trim()) {
         this.set(label);
      }

      return this.element.fade('in');
   },

   // Hides the tooltip
   hide : function() {
      return this.element.fade('out');
   },

   // Updates tooltip on event
   update : function(label) {

      this._attach(this.container);
      this.show(label);

   }

});



/**
 * Creates a message (centered alert)
 */
var Message = new Class({

   Implements : [ Options ],

   type : XTypes.Message,

   initialize : function(txt, options) {

      this.setOptions(options);

      this._create(txt);
      this._position();
      this._register();
      this.show();

   },

   // Creates a message
   _create : function(txt) {

      this.element = new Element('div', {
         'class' : 'xirt-alert',
         'text' : txt
      }).inject(document.body);

      var box = new Element('div', {
         'class' : 'box-buttons'
      }).inject(this.element);

      box.grab(new Element('button', {
         'text' : XLang.misc['close']
      }).addEvent('click', this.hide.bind(this)));

      this.element.grab(box);

   },

   // Position the message (centered)
   _position : function(el) {

      this.element.position({
         relativeTo : $('body'),
         position : 'center',
         edge : 'bottom',
         offset : {
            x : 0,
            y : -100
         }
      }).fade('hide');

   },

   // Registers the message with Xirt
   _register : function() {
      XRegister.add(this);
   },

   // Shows the message
   show : function() {
      return this.element.fade('in');
   },

   // Hides the message
   hide : function() {

      XRegister.remove(this);
      return this.element.fade('out');

   }

});



/**
 * Creates a background fog (fullscreen)
 */
var Fog = new Class({

   Implements : Options,

   element : null,
   options : {
      opacity : 0.5
   },

   // Constructor
   initialize : function(options) {

      this.setOptions(options);
      if (!(this.element = $('xBG')) || !this.element) {
         this._create();
      }

   },

   // Creates the element
   _create : function(txt) {

      this.element = new Element('div', {
         'class' : 'xirt-overlay',
         'id' : 'xBG'
      }).inject(document.body);

   },

   // Resizes the element (to full screen size)
   _resize : function() {

      this.element.setStyles({
         'width' : screen.width + 'px',
         'height' : screen.height + 'px'
      });

   },

   // Shows the element
   show : function() {

      this.hide(1);
      this._resize();

      return this.element.fade(this.options.opacity);
   },

   // Hides the element
   hide : function(fast) {
      return this.element.fade(fast ? 'hide' : 'out');
   }

});



/**
 * Class for submitting forms (prevents MooTools bug)
 * 
 * Extends: Request (MooTools)
 */
Request.Form = new Class({

   Extends : Request,

   initialize : function(form, options) {

      options = options ? options : {};
      options.data = form;

      this.parent(options);

   }

});
