var ContentList = new Class({

   Extends: XList,

   initialize: function(component) {
   
      this.parent(component, {
         sortable: true,
         sortables: ['id', 'rank', 'name', 'username', 'mail', 'joined'],
         column: 'id'
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
               text: item.rank
            }).addClass('cell-rank'));

            row.grab(new Element('td', {
               text: item.name
            }).addClass('cell-name'));

            row.grab(new Element('td', {
               text: item.username
            }).addClass('cell-username'));

            row.grab(new Element('td', {
               text: item.mail
            }).addClass('cell-mail'));

            row.grab(new Element('td', {
               text: item.joined
            }).addClass('cell-joined'));

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
            'src': '../images/cms/icons/password.png'
         }).store('id', item.id)
         .addEvent('click', XManager.resetPassword));

         var opacity = Math.min(item.id - 0.75, 1);
         cell.grab(new Element('img', {
            'class': 'url',
            'src': '../images/cms/icons/remove.png'
         }).store('id', item.id)
         .setStyle('opacity', opacity)
         .addEvent('click', XManager.remove));

      row.grab(cell);

   }

});
