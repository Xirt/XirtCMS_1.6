var ContentList = new Class({

   Extends: XList,

   show: function() {

      Array.each(this.list, function (item, key) {

         item.active = parseInt(item.active);
         item.published = parseInt(item.published);

         var row = this.createRow(true, item.published);

            row.grab(new Element('td', {
               text: key + 1 + '.'
            }).addClass('cell-id'));

            row.grab(new Element('td', {
               text: item.name
            }).addClass('cell-name'));

            row.grab(new Element('td', {
               text: item.folder
            }).addClass('cell-folder'));

            this._createStatus(row, item);
            this._createDefault(row, item);
            this._createOptions(row, item);

         this.container.grab(row);

      }, this);

   },

   _createStatus: function(row, item) {

      cell = new Element('td', {
         'class' : 'cell-published'
      });

         cell.grab(new Element('img', {
            'src': '../images/cms/icons/published_' + item.published + '.png',
            'class': 'url'
         }).addEvent('click', XManager.toggleStatus)
         .store('status', item.published)
         .store('id', item.id));

      row.grab(cell);

   },

   _createDefault: function(row, item) {

      cell = new Element('td', {
         'class' : 'cell-default'
      });

         var img = item.active ? 'check' : 'bar';
         cell.grab(new Element('img', {
            'src': '../images/cms/icons/' + img + '.png',
            'class': 'url'
         }).addEvent('click', XManager.toggleActive)
         .store('status', item.active)
         .store('id', item.id));

      row.grab(cell);

   },

   _createOptions: function(row, item) {

      cell = new Element('td', {
         'class' : 'cell-options'
      });

         cell.grab(new Element('img', {
            'class': 'url',
            'src': '../images/cms/icons/edit.png'
         }).store('id', item.id)
         .addEvent('click', XManager.showEditForm));

         cell.grab(new Element('img', {
            'class': 'url',
            'src': '../images/cms/icons/config.png'
         }).store('id', item.id)
         .addEvent('click', XManager.showConfigForm));

         cell.grab(new Element('img', {
            'class': 'url',
            'src': '../images/cms/icons/remove.png'
         }).store('id', item.id)
         .addEvent('click', XManager.remove));

      row.grab(cell);

   }

});