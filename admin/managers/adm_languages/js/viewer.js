var ContentList = new Class({

   Extends: XList,

   show: function() {

      Array.each(this.list, function (item, key) {

         item.published = parseInt(item.published);

         var row = this.createRow(true);

            row.grab(new Element('td', {
               text: (key + 1) + '.'
            }).addClass('cell-id'));

            row.grab(new Element('td').grab(new Element('img', {
               'src':  '../images/cms/flags/' + item.iso + '.png'
            })).addClass('cell-flag'));

            row.grab(new Element('td', {
               text: item.iso
            }).addClass('cell-iso'));

            row.grab(new Element('td', {
               text: item.name
            }).addClass('cell-name'));

            this._createPreference(row, item);
            this._createStatus(row, item);
            this._createOptions(row, item);

         this.container.grab(row);

      }, this);

   },

   _createPreference: function(row, item) {

      var cell = new Element('td', {
         'class' : 'cell-preference'
      });

         cell.grab(new Element('button', {
            'type': 'button',
            'class': 'move-down'
         }).store('id', item.id)
         .addEvent('click', XManager.moveDown));

         cell.grab(new Element('button', {
            'type': 'button',
            'class': 'move-up'
         }).store('id', item.id)
         .addEvent('click', XManager.moveUp));

      row.grab(cell);

   },

   _createStatus: function(row, item) {

      var cell = new Element('td', {
         'class' : 'cell-status'
      }).inject(row);

         cell.grab(new Element('img', {
            'src': '../images/cms/icons/published_' + item.published + '.png',
            'class': 'url'
         }).addEvent('click', XManager.toggleStatus)
        .store('cStatus', item.published)
        .store('id', item.id));

      row.grab(cell);

   },

   _createOptions: function(row, item) {

      new Element('td', {
         'class' : 'cell-options'
      }).inject(row);

   }

});
