var ContentList = new Class({

   Extends: XList,

   initialize: function(component) {
   
      this.parent(component, {
         sortable: true,
         sortables: ['xid', 'name', 'type', 'position', 'published', 'mobile'],
         column: 'position'
      });

   },

   show: function() {

      Array.each(this.list, function (item) {

         item.mobile = parseInt(item.mobile);
         item.published = parseInt(item.published);
         item.preference = (item.language == XManager.language);

         var row = this.createRow(item.preference);

            row.grab(new Element('td', {
               text: XAdmin.createId(item.xid)
            }).addClass('cell-xid'));

            row.grab(new Element('td', {
               text: item.name
            }).addClass('cell-name'));

            row.grab(new Element('td', {
               text: item.type
            }).addClass('cell-type'));

            row.grab(new Element('td', {
               text: item.position
            }).addClass('cell-position'));

            this._createStatus(row, item);
            this._createOptions(row, item);

         this.container.grab(row);

      }, this);
      
      new Tooltips('.tooltip');
   },

   _createStatus: function(row, item) {

      var statusCell = new Element('td', {
         'class' : 'cell-published'
      }).inject(row);

      var mobileCell = new Element('td', {
         'class' : 'cell-mobile'
      }).inject(row);

      if (item.preference) {

         statusCell.grab(new Element('img', {
            'src': '../images/cms/icons/published_' + item.published + '.png',
            'title' : XComLang.tips['status'],
            'class': 'url tooltip'
         }).addEvent('click', XManager.toggleStatus)
        .store('status', item.published)
        .store('id', item.id));

         mobileCell.grab(new Element('img', {
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

         return cell.grab(new Element('img', {
            'class': 'url tooltip',
            'title' : XComLang.tips['translate'],
            'src': '../images/cms/icons/new.png'
         }).addEvent('click', XManager.addTranslation)
         .store('language', item.language)
         .store('xId', item.xid));

      }

      cell.grab(new Element('img', {
         'class': 'url tooltip',
         'title' : XComLang.tips['edit'],
         'src': '../images/cms/icons/edit.png'
      }).addEvent('click', XManager.showEditPanel)
      .store('id', item.id));

      cell.grab(new Element('img', {
         'class': 'url tooltip',
         'title' : XComLang.tips['config'],
         'src': '../images/cms/icons/config.png'
      }).addEvent('click', XManager.showConfigPanel)
      .store('id', item.id));

      cell.grab(new Element('img', {
         'class': 'url tooltip',
         'title' : XComLang.tips['access'],
         'src': '../images/cms/icons/access.png'
      }).addEvent('click', XManager.showAccessPanel)
      .store('id', item.id));

      cell.grab(new Element('img', {
         'class': 'url tooltip',
         'title' : XComLang.tips['remove'],
         'src': '../images/cms/icons/remove.png'
      }).addEvent('click', XManager.removeTranslation)
      .store('id', item.id));

   }

});