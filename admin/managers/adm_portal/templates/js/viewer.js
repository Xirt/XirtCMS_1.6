var ContentList = new Class({

   Extends: XList,

   initialize: function(component) {
   
      this.parent(component, {
         sortable: true,
         sortables: ['id', 'error_no', 'error_msg', 'time'],
         limit: 25,
         column: 'id',
         order: 'DESC'
      });

   },

   show: function() {

      Array.each(this.list, function (item, key) {

         item.id = parseInt(item.id);

         row = this.createRow(true);

            row.grab(new Element('td', {
               text: XAdmin.createId(item.id)
            }).addClass('cell-id'));

            row.grab(new Element('td', {
               html: '&nbsp;'
            }).addClass('cell-error_no type-' + item.error_no));

            row.grab(new Element('td', {
               text: item.error_msg
            }).addClass('cell-error_msg'));

            row.grab(new Element('td', {
               text: item.time
            }).addClass('cell-time'));

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
            'src': '../images/cms/icons/view.png'
         }).store('id', item.id)
         .addEvent('click', XManager.showEntryPanel));

         cell.grab(new Element('img', {
            'class': 'url',
            'src': '../images/cms/icons/remove.png'
         }).store('id', item.id)
         .addEvent('click', XManager.remove));

      row.grab(cell);

   }

});
