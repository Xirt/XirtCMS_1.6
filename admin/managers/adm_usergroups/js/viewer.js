var ContentList = new Class({

   Extends: XList,

   initialize: function(component) {
   
      this.parent(component, {
         sortable: true,
         sortables: ['rank', 'name'],
         column: 'rank'
      });

   },

   show: function() {

      Array.each(this.list, function (item) {

         item.removable = parseInt(item.removable);
         item.preference = (item.language == XManager.language);

         row = this.createRow(item.preference);

            row.grab(new Element('td', {
               text: item.rank
            }).addClass('cell-rank'));

            row.grab(new Element('td', {
               text: item.name
            }).addClass('cell-name'));

            this._createOptions(row, item);

         this.container.grab(row);

      }, this);

   },

   _createOptions: function(row, item) {

      cell = new Element('td', {
         'class' : 'cell-options'
      }).inject(row);

      if (!item.preference) {

         cell.grab(new Element('img', {
            'class': 'url',
            'src': '../images/cms/icons/new.png'
         }).store('xId', item.rank)
         .store('language', item.language)
         .addEvent('click', XManager.addTranslation));

         return false;
      }

      cell.grab(new Element('img', {
         'class': 'url',
         'src': '../images/cms/icons/edit.png'
      }).store('id', item.id)
      .addEvent('click', XManager.showEditPanel));

      cell.grab(new Element('img', {
         'class': 'url',
         'src': '../images/cms/icons/remove.png'
      }).store('id', item.id)
      .addEvent('click', XManager.removeTranslation));

   }

});
