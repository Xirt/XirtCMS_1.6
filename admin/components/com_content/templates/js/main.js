var XManager = new Class({

   // All elements
   items: new Array(
      'item_show_title', 'item_show_author', 'item_show_created',
      'item_show_modified'
   ),

   // All icons
   icons: new Array(
      'item_back_icon', 'item_download_icon', 'item_print_icon',
      'item_mail_icon'
   ),

   // Initializes manager
   initialize: function() {

      this.form = $('xForm');
      var validator = new XValidator(this.form, {
         onFormValidate: this._save.bind(this)
      });

      Array.each(this.items, function(el) {
         $(el).addEvent('change', this.toggleView);
      }, this);

      Array.each(this.icons, function(el) {
         $(el).addEvent('change', this.toggleIcon);
      }, this);

      this._reset();
      $('xReset').addEvent('click', this._reset.bind(this));

   },

   // Toggles elements
   toggleView: function() {

      var id = this.id;
      var target = $(id.substr(5));

      var options = new Array('none', 'block');
      target.setStyle('display', options[this.value]);

   },

   // Toggles icons
   toggleIcon: function() {

      var id = this.id;
      var target = $(id.substr(5));

      var options = new Array('none', 'inline-block');
      target.setStyle('display', options[this.value]);

   },

   // Resets form
   _reset: function() {

      this.form.reset();

      Array.each(this.items, function(el) {
         $(el).fireEvent('change');
      });

      Array.each(this.icons, function(el) {
         $(el).fireEvent('change');
      });

   },

   // Submits form
   _save: function(validateOutput, el, event) {

      event.stop();

      if (validateOutput) {

         new Request.Form(this.form, {
            onFailure: XAdmin.showError,
            onSuccess: XManager._finished
         }).send();

      }

   },

   // Shows result
   _finished: function() {
      Xirt.showNotice(XLang.messages['saved']);
   }

});

window.addEvent('domready', function() {
   XManager = new XManager();
});
