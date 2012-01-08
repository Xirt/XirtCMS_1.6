var XManager = new Class({

   Extends: XDefaultManager,

   showAccessPanel: function() {
      new AccessPanel(this.retrieve('id'));
   }

});

window.addEvent('domready', function() {
   XManager = new XManager('adm_components');
   XManager.load();
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

      this.parent(id);
   }

});