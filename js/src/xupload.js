var XUpload = new Class({

   Implements: [Events, Options],

   ID_KEY : 'APC_UPLOAD_PROGRESS',
   delay : 5,

   initialize : function(options) {

      this.form = $(options.form);
      if (this.form[this.ID_KEY]) {
         return false;
      }

      this.setOptions(options);
      this._setProgressBar();
      this._setTarget();
      this._setAPC();

      this.form.addEvent('submit', this._onSubmit.bind(this));
   },

   _setProgressBar: function() {
      if (!$(this.options.progressBar)) {
         this.options.progressBar = new Element('div');
      }
   },

   // METHOD: Sets the (invisible) target of the form
   _setTarget: function() {

      if (!this.form.target) {

         var targetFrame = Number.random(0, 1000);
         this.form.target = targetFrame;

         new Element('iframe', {
            name: targetFrame
         }).hide().inject(this.form);

      }

   },

   // METHOD: Sets the (invisible) APC-ID element for the form
   _setAPC: function() {

      if (!this.form[this.ID_KEY]) {
         this.apc = new Element('input', {
            name : this.ID_KEY,
            type : 'hidden'
         }).inject(this.form, 'top');
      }

      this.apc = Number.random(0, 9999);
      this.form[this.ID_KEY].value = this.apc;
   },

   // METHOD :: Starts tracking the upload procedure
   _onSubmit : function(event) {

      this.progressBar = new Fx.XProgressBar(this.options.progressBar);
      if (this.options.progressBar) {
         this.progressBar.start(0);
      }

      this.fireEvent('start');
      this._retrieve();
   },


  /**
   * Retrieves the current upload status (request)
   */
   _retrieve : function() {

      new Request.JSON({
         url: 'index.php',
         onFailure: Xirt.showError,
         onSuccess: this._receive.bind(this)
      }).post({
         content: 'adm_helper',
         task: 'show_upload_progress',
         id: this.apc
      });

   },


  /**
   * Receives the current upload status (receival)
   */
   _receive: function(transport) {

      this.progressBar.set(transport.percent);

      // STATUS: Uploading
      if (!transport.finished) {
         this._retrieve.delay(this.delay, this, transport.id);
         return this.fireEvent('update');
      }

      // STATUS: Failure
      if (transport.error) {
         this.progressBar.hide();
         Xirt.showNotice(transport.error);
         return this.fireEvent('failure');
      }

      // STATUS: Finished
      this.progressBar.hide();
      Xirt.showNotice(XLang.messages['success']);
      return this.fireEvent('complete');
   }

});



/**
 * Class that shows / updates a progressbar
 *
 * @see XUpload
 */
Fx.XProgressBar = new Class({

	Extends: Fx,

	options: {
		transition: Fx.Transitions.Circ.easeOut
	},

   // CONSTRUCTOR
	initialize: function(element, options) {

		this.holder = $(element).hide();
      this.holder.addClass('xProgressBox');

      this.bar = this.holder.getElement('.xProgressBar');
      if (!this.bar) {
         this.bar = new Element('div', {
            'class' : 'xProgressBar'
         }).inject(this.holder);
      }

		this.parent(options);
	},

   /**
    * Start / shows the progressbar
    */
   start: function() {
		this.set(0);
      this.holder.show();
   },

   /**
    * Update the bar to the given value
    */
   set: function(val) {
      var stepWidth = this.holder.getSize().x / 100;
      this.bar.setStyle('width', (val * Math.round(stepWidth)) + 'px');
      this.now = val;
   },

   /**
    * Hides the bar
    */
   hide: function() {
      this.holder.hide();
   }

});