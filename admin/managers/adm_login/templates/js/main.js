var XManager = new Class({

   initialize: function() {

      $('form-login').addEvent('submit', function(event) {

         new LoginAttempt(this);
         event.stop();

      });

      $('a-password').addEvent('click', function(event) {

         new ResetPanel();
         event.stop();

      });

   }

});

window.addEvent('load', function() {
   XManager = new XManager();
});


/**************************
* Class to attempt logins *
**************************/
var LoginAttempt = new Class({

   // METHOD :: Initializes attempt
   initialize: function(form) {

      new Request.Form(form, {
         onFailure: function(a) {alert(a); },
         onSuccess: this._finished.bind(this)
      }).send();

   },

   // METHOD :: Shows login result
   _finished: function(output) {

      if (output && output.length) {
         return Xirt.showNotice(output);
      }

      location.reload(true);
   }

});


/******************************
* Class to show 'reset'-panel *
******************************/
var ResetPanel = new Class({

   Extends: AddPanel,

   // METHOD :: Initializes panel
   initialize: function() {

      this.panel = 'dvRequestPassword';
      this.options.width = 450;
      this.parent();

   },

   // METHOD :: Hides the panel after transfer
   _finished: function(output) {

      Xirt.showNotice(output);
      this.hide();      

   }
   
});