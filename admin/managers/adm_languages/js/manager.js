var XManager = new Class({

   Extends: XDefaultManager,

   // METHOD :: Move item down the list
   moveDown: function(event) {

      var el = this.getParent('tr');
      if (typeOf(el.getNext()) != 'element') {
         return el.highlight('#ff7979');
      }

      new Request({
         onFailure: Xirt.showError,
         onSuccess: XManager.reload.bind(XManager),
         url: 'index.php'
      }).post({
         content: XManager.component,
         task: 'move_down',
         id: this.retrieve('id')
      });

   },

   // METHOD :: Move item up the list
   moveUp: function(event) {

      var el = this.getParent('tr');
      if (typeOf(el.getPrevious()) != 'element') {
         return el.highlight('#ff7979');
      }

      new Request({
         onFailure: Xirt.showError,
         onSuccess: XManager.reload.bind(XManager),
         url: 'index.php'
      }).post({
         content: XManager.component,
         task: 'move_up',
         id: this.retrieve('id')
      });

   },

   // METHOD :: Toggles status (published / unpublished)
   toggleStatus: function() {

      var el = this.getParent('tr');
      if (typeOf(el.getPrevious()) != 'element') {
         return el.highlight('#ff7979');
      }

      new Request({
         onFailure: Xirt.showError,
         onSuccess: XManager.reload.bind(XManager),
         url: 'index.php'
      }).post({
         content: XManager.component,
         task: 'toggle_status',
         id: this.retrieve('id')
      });

   }

});

window.addEvent('domready', function() {
   XManager = new XManager('adm_languages');
   XManager.load();
});
