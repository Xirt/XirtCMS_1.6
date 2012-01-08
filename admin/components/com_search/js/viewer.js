var ContentList = new Class({

   Extends: XList,

   initialize: function(component) {
   
      this.parent(component, {
         sortable: true,
         sortables: ['term', 'uri', 'impressions'],
         column: 'impressions',
      });

   },

   show: function() {

      Array.each(this.list, function (item, key) {

         var row = new Element('tr');

            row.grab(new Element('td', {
               text: key + 1 + '.'
            }).addClass('cell-id'));

            row.grab(new Element('td', {
               text: item.term
            }).addClass('cell-term'));

            row.grab(new Element('td', {
               text: item.uri
            }).addClass('cell-uri'));

            row.grab(new Element('td', {
               text: item.impressions
            }).addClass('cell-impressions'));

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
         }).addEvent('click', XManager.showEditForm)
         .store('id', item.id));

         cell.grab(new Element('img', {
            'class': 'url',
            'src': '../images/cms/icons/remove.png'
         }).addEvent('click', XManager.remove)
         .store('id', item.id));

      row.grab(cell);
   }

});
