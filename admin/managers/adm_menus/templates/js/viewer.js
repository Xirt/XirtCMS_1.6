var ContentList = new Class({

   Extends: XList,

   show: function() {

      Array.each(this.list, function (item) {

         item.mobile = parseInt(item.mobile);
         item.sitemap = parseInt(item.sitemap);
         item.published = parseInt(item.published);
         item.preference = (item.language == XManager.language);

         var row = this.createRow(item.preference);

            row.grab(new Element('td', {
               text: XAdmin.createId(item.xid)
            }).addClass('cell-id'));

            row.grab(new Element('td', {
               text: item.title
            }).addClass('cell-title'));

            this._createOrdering(row, item);
            this._createStatus(row, item);
            this._createOptions(row, item);

         this.container.grab(row);

      }, this);
      
      new Tooltips('.tooltip');
   },

   _createOrdering: function(row, item) {

      var cell = new Element('td', {
         'class' : 'cell-ordering'
      });

         cell.grab(new Element('button', {
            'type': 'button',
            'class': 'move-down tooltip',
            'title' : XComLang.tips['moveDown']
         }).store('xId', item.xid)
         .addEvent('click', XManager.moveDown));
   
         cell.grab(new Element('button', {
            'type': 'button',
            'class': 'move-up tooltip',
            'title' : XComLang.tips['moveUp']
         }).store('xId', item.xid)
         .addEvent('click', XManager.moveUp));

      row.grab(cell);

   },

   _createStatus: function(row, item) {

      var sCell = new Element('td', {
         'class' : 'cell-sitemap'
      }).inject(row);

      var mCell = new Element('td', {
         'class' : 'cell-mobile'
      }).inject(row);

      if (item.preference) {

         sCell.grab(new Element('img', {
            'src': '../images/cms/icons/visible.png',
            'title' : XComLang.tips['sitemap'],
            'class': 'url tooltip'
         }).addEvent('click', XManager.toggleSitemap)
        .setStyle('opacity', item.sitemap + 0.5)
        .store('status', item.sitemap)
        .store('id', item.id));


         mCell.grab(new Element('img', {
            'src': '../images/cms/icons/visible.png',
            'title' : XComLang.tips['mobile'],
            'class': 'url tooltip'
         }).addEvent('click', XManager.toggleMobile)
        .setStyle('opacity', item.mobile + 0.5)
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
            'class': 'url tooltip',
            'title' : XComLang.tips['translate'],
            'src': '../images/cms/icons/new.png'
         }).store('xId', item.xid)
         .store('language', item.language)
         .addEvent('click', XManager.addTranslation));

         return false;
      }

      cell.grab(new Element('img', {
         'class': 'url tooltip',
         'title' : XComLang.tips['edit'],
         'src': '../images/cms/icons/edit.png'
      }).store('id', item.id)
      .addEvent('click', XManager.showEditPanel));

      cell.grab(new Element('img', {
         'class': 'url tooltip',
         'title' : XComLang.tips['menu'],
         'src': '../images/cms/icons/menu.png'
      }).store('xId', item.xid)
      .addEvent('click', XManager.goContent));

      cell.grab(new Element('img', {
         'class': 'url tooltip',
         'title' : XComLang.tips['remove'],
         'src': '../images/cms/icons/remove.png'
      }).store('id', item.id)
      .addEvent('click', XManager.removeTranslation));

   }

});