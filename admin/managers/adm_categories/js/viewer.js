var ContentList = new Class({

   Extends: XList,

   show: function() {

      this._updateParentLists($('nx_parent_id'));
      this._updateParentLists($('x_parent_id'));

      Array.each(this.list, function (item) {

         item.home = parseInt(item.home);
         item.mobile = parseInt(item.mobile);
         item.sitemap = parseInt(item.sitemap);
         item.published = parseInt(item.published);
         item.preference = (item.language == XManager.language);

         var row = this.createRow(item.preference);
         row.store('level', item.level);

            row.grab(new Element('td', {
               'class': 'cell-id',
               'text': XAdmin.createId(item.xid)
            }));

            this._createName(row, item);
            this._createOrdering(row, item);
            this._createStatus(row, item);
            this._createOptions(row, item);

         this.container.grab(row);

      }, this);

   },

   _createName: function(row, item) {

      cell = new Element('td', {
         'class' : 'cell-name'
      }).inject(row);


         if (item.level > 1) {
 
            var indent = XAdmin.createIdent((item.level - 1) * 4);
            cell.appendText(indent);
            cell.grab(new Element('sup', { text : 'L ' }));

         }

      row.grab(cell.appendText(item.name));

   },

   _createOrdering: function(row, item) {

      var cell = new Element('td', {
         'class' : 'cell-ordering'
      }).inject(row);

         cell.grab(new Element('button', {
            'type': 'button',
            'class': 'move-down'
         }).store('xId', item.xid)
         .addEvent('click', XManager.moveDown));

         cell.grab(new Element('button', {
            'type': 'button',
            'class': 'move-up'
         }).store('xId', item.xid)
         .addEvent('click', XManager.moveUp));

      row.grab(cell);

   },

   _createStatus: function(row, item) {

      var pCell = new Element('td', {
         'class' : 'cell-status'
      }).inject(row);

      var sCell = new Element('td', {
         'class' : 'cell-sitemap'
      }).inject(row);

      var mCell = new Element('td', {
         'class' : 'cell-mobile'
      }).inject(row);

      if (item.preference) {

         pCell.grab(new Element('img', {
            'src': '../images/cms/icons/published_' + item.published + '.png',
            'class': 'url'
         }).addEvent('click', XManager.toggleStatus)
         .store('status', item.published)
         .store('id', item.id));

         sCell.grab(new Element('img', {
            'src': '../images/cms/icons/visible.png',
            'class': 'url'
         }).addEvent('click', XManager.toggleSitemap)
         .setOpacity(item.sitemap + 0.5)
         .store('status', item.sitemap)
         .store('id', item.id));

         mCell.grab(new Element('img', {
            'src': '../images/cms/icons/visible.png',
            'class': 'url'
         }).addEvent('click', XManager.toggleMobile)
         .setOpacity(item.mobile + 0.5)
         .store('status', item.mobile)
         .store('id', item.id));

      }

   },

   _createOptions: function(row, item) {

      var cell = new Element('td', {
         'class' : 'cell-options'
      }).inject(row);

      if (!item.preference) {

         cell.grab(new Element('img', {
            'class': 'url',
            'src': '../images/cms/icons/new.png'
         }).store('xId', item.xid)
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
         'src': '../images/cms/icons/config.png'
      }).store('id', item.id)
      .addEvent('click', XManager.showConfigPanel));

      cell.grab(new Element('img', {
         'class': 'url',
         'src': '../images/cms/icons/access.png'
      }).store('id', item.id)
      .addEvent('click', XManager.showAccessPanel));

      cell.grab(new Element('img', {
         'class': 'url',
         'src': '../images/cms/icons/remove.png'
      }).store('id', item.id)
      .addEvent('click', XManager.removeTranslation));

   },

   // METHOD :: Updates parent select fields
   _updateParentLists: function(el) {

      var current = el.value;
      el.getChildren('option[value!=0]').dispose();

      this.list.each(function (item) {

         var indent = XAdmin.createIdent((item.level - 1) * 5, '- ');
         el.grab(new Element('option', {
            value : item.xid,
            text : indent + item.name
         }));

      });

      el.value = current;
   }

});