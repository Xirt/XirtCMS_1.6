var ContentList = new Class({

   Extends: XList,

   initialize: function(component) {
   
      this.parent(component, {
         sortable: true,
         sortables: ['id', 'name'],
         column: 'name'
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
               text: item.name
            }).addClass('cell-name'));

            this._createOptions(row, item);

         this.container.grab(row);

      }, this);

   },

   _createOptions: function(row, item) {

      var cell = new Element('td', {
         'class' : 'cell-options'
      }).inject(row);

      if (item.id != 1) {

         cell.grab(new Element('img', {
            'class': 'url',
            'src': '../images/cms/icons/access.png'
         }).store('id', item.id)
         .addEvent('click', XManager.showAccessPanel));

      }

   }

});