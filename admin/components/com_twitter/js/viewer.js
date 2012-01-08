var ContentList = new Class({

   Extends: XList,

   initialize: function(component) {
   
      this.parent(component, {
         sortable: true,
         sortables: ['author', 'content', 'created', 'status'],
         column: 'created',
      });

   },

   show: function() {

      this.list.reverse();
      
      Array.each(this.list, function (item, key) {

         item.published = parseInt(item.published);
         
         row = this.createRow(true);

            row.grab(new Element('td', {
               text: item.author
            }).addClass('cell-author'));

            row.grab(new Element('td', {
               html: item.content
            }).addClass('cell-content'));

            row.grab(new Element('td', {
               html: item.created
            }).addClass('cell-created'));

            this._createStatus(row, item);
            this._createOptions(row, item);

         this.container.grab(row);

      }, this);

   },

   _createStatus: function(row, item) {

      var cell = new Element('td', {
         'class' : 'cell-status'
      });

         cell.grab(new Element('img', {
            'src': '../images/cms/icons/published_' + item.published + '.png',
            'class': 'url'
         }).addEvent('click', XManager.toggleStatus)
         .store('status', item.published)
         .store('id', item.id));

      row.grab(cell);
         
   },

   _createOptions: function(row, item) {

      var cell = new Element('td', {
         'class' : 'cell-options'
      });

         cell.grab(new Element('img', {
            'class': 'url',
            'src': '../images/cms/icons/remove.png'
         }).store('id', item.id)
         .addEvent('click', XManager.remove));

      row.grab(cell);

   }

});