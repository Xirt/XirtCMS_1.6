var ContentList = new Class({

   Extends: XList,

   initialize: function(component) {
   
      this.parent(component, {
         sortable: true,
         sortables: ['alternative', 'query', 'cid'],
         column: 'alternative'
      });

   },

   show: function() {

      Array.each(this.list, function (item, key) {

         row = this.createRow(true);

            row.grab(new Element('td', {
               text: key + 1 + '.'
            }).addClass('cell-id'));

            row.grab(new Element('td', {
               text: item.alternative
            }).addClass('cell-alternative'));

            row.grab(new Element('td', {
               text: item.query
            }).addClass('cell-query'));

            row.grab(new Element('td', {
               text: item.cid
            }).addClass('cell-cid'));

            this._createOptions(row, item);

         this.container.grab(row);

      }, this);
      
      new Tooltips('.tooltip');
   },

   _createOptions: function(row, item) {

      var cell = new Element('td', {
         'class' : 'cell-options'
      });

         cell.grab(new Element('img', {
            'class': 'url tooltip',
            'title' : XComLang.tips['edit'],
            'src': '../images/cms/icons/edit.png'
         }).store('id', item.id)
         .addEvent('click', XManager.showEditForm));

         cell.grab(new Element('img', {
            'class': 'url tooltip',
            'title' : XComLang.tips['remove'],
            'src': '../images/cms/icons/remove.png'
         }).store('id', item.id)
         .addEvent('click', XManager.remove));

      row.grab(cell);

   }

});
