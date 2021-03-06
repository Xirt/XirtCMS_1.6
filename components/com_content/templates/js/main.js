var TellAFriend = new Class({

   window: null,

   // Initializes layover
   initialize: function() {
      
      this.element = $('xTellAFriend');
      this.form = this.element.getElement('form');
      
      this._validation();
      this.show();

   },

   // Add validation to form
   _validation: function() {

      var validator = new XValidator(this.form, {
         onFormValidate: this._onSend.bind(this)
      });

      this.form.removeEvents();
      this.form.addEvent('submit', validator.validate.bind(validator));

   },
   
   // Sends input to server
   _onSend: function(validateOutput, el, event) {

      event.stop();

      if (validateOutput) {

         new Request.Form(this.form, {
            onFailure: this._onFailure.bind(this),
            onSuccess: this._onFinish.bind(this)
         }).send();

      }
      
   },

   // Executed on completion
   _onFinish: function() {

      Xirt.showNotice(XLang.messages['success']);
      this.hide();

   },

   // Executed on failure
   _onFailure: function() {
      Xirt.showNotice(XLang.messages['failed']);
   },
   
   // Shows layover
   show: function() {
   
      if (!this.window) {
         this.window = new Window(this.element.show(), 450);
      }

      this.window.show();   
   },
   
   // Hides layover
   hide: function() {
      this.window.hide();
   }   

});

window.addEvent('domready', function() {

   if ($('xBack')) {
      
      $('xBack').addEvent('click', function(e) {
   
         history.go(-1);
         e.stop();   
   
      });

   }

   if ($('xMail')) {

      $('xMail').addEvent('click', function(e) {

         new TellAFriend();
         e.stop();   
   
      });

   }

});