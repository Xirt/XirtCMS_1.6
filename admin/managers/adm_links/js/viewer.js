var ContentList = new Class({

   Extends: XList,

   initialize: function(component) {
   
      this.parent(component, {
         sortable: true,
         sortables: ['uri_sef', 'uri_ori', 'cid'],
         column: 'uri_sef'
      });

   },

   show: function() {

      Array.each(this.list, function (item, key) {

         row = this.createRow(true);

            row.grab(new Element('td', {
               text: key + 1 + '.'
            }).addClass('cell-id'));

            row.grab(new Element('td', {
               text: item.uri_sef
            }).addClass('cell-uri_sef'));

            row.grab(new Element('td', {
               text: item.uri_ori
            }).addClass('cell-uri_ori'));

            row.grab(new Element('td', {
               text: item.cid
            }).addClass('cell-cid'));

            this._createOptions(row, item);

         this.container.grab(row);

      }, this);

   },

   _createOptions: function(row, item) {

      var cell = new Element('td', {
         'class' : 'cell-options'
      });

         cell.grab(new Element('img', {
            'class': 'url',
            'src': '../images/cms/icons/edit.png'
         }).store('id', item.id)
         .addEvent('click', XManager.showEditForm));

         cell.grab(new Element('img', {
            'class': 'url',
            'src': '../images/cms/icons/remove.png'
         }).store('id', item.id)
         .addEvent('click', XManager.remove));

      row.grab(cell);

   }

});
