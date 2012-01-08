var XManager = new Class({

   Extends: XDefaultManager,

   // METHOD :: Removes item
   remove: function() {

      if (confirm(XLang.confirmRemove)) {

         new Request({
            onFailure: Xirt.showError,
            onSuccess: XManager.removeCompleted,
            url: 'index.php'
         }).post({
            content: 'com_twitter',
            task: 'remove_item',
            id: this.retrieve('id')
         });

      }

   },

   // METHOD :: Shows removal completion
   removeCompleted: function(transport) {

      Xirt.showNotice(XLang.mRemoved);
      XManager.reload();

   }

});
window.addEvent('domready', function() {

   XManager = new XManager('com_twitter');
   XManager.load();

});
