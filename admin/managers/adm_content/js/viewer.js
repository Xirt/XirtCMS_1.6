var CategoryList = new Class({

   Implements: [Events, Options],
   options: {},
   list: [],
   
   initialize: function(options) {      
      this.setOptions(options);
   },

   load: function() {

      new Request.JSON({
         onFailure: Xirt.showError,
         onSuccess: this._receive.bind(this),
         url: 'index.php'
      }).post({
         content: 'adm_content',
         task: 'show_category_list',
         iso: XManager.iso
      });
   
   },

   reload: function() {
      this.load();
   },

   _receive: function(json) {

      this.list = new Array();
      Array.each(json, function(item) {
         this.list[this.list.length] = item;
      }, this);
      
      this.fireEvent('complete', this.list);
      this._update();

   },
   
   _update: function() {

      Array.each(['nx_category', 'x_category'], function(list) {

         var el = $(list).hide();
         
         // Add categories to list
         Array.each(this.list, function(option) {

            var level = parseInt(option.level);
            var indent = XAdmin.indent((level - 1) * 2, '- ');
            
            el.grab(new Element('option', {
               value: option.xid,
               text: indent + option.name
            })).show();

         }, this);

      }, this);

   },

   toArray: function() {
      return this.list;      
   }

});



var ContentList = new Class({
   
   Extends: XList,

   initialize: function(component) {
   
      this.parent(component, {
         sortable: true,
         sortables: ['xid', 'title', 'name', 'category'],
         column: 'title'
      });

   },
   
   show: function() {

      Array.each(this.list, function (item) {

         item.mobile = parseInt(item.mobile);
         item.category = parseInt(item.category);
         item.published = parseInt(item.published);
         item.preference = (item.language == XManager.language);

         var row = this.createRow(item.preference);

            row.grab(new Element('td', {
               text: XAdmin.createId(item.xid)
            }).addClass('cell-xid'));

            row.grab(new Element('td', {
               text: item.title
            }).addClass('cell-title'));

            row.grab(new Element('td', {
               text: this._getCategory(item.category)
            }).addClass('cell-category'));

            this._createStatus(row, item);
            this._createOptions(row, item);

         this.container.grab(row);

      }, this);

   },

   _createStatus: function(row, item) {

      var statusCell = new Element('td', {
         'class' : 'cell-status'
      }).inject(row);

      var mobileCell = new Element('td', {
         'class' : 'cell-mobile'
      }).inject(row);

      if (item.preference) {

         statusCell.grab(new Element('img', {
            'src': '../images/cms/icons/published_' + item.published + '.png',
            'class': 'url'
         }).addEvent('click', XManager.toggleStatus)
         .store('status', item.published)
         .store('id', item.id));

         mobileCell.grab(new Element('img', {
            'src': '../images/cms/icons/visible.png',
            'class': 'url'
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
            'class': 'url',
            'src': '../images/cms/icons/new.png'
         }).addEvent('click', XManager.addTranslation)
         .store('language', item.language)
         .store('xId', item.xid));

     }

      cell.grab(new Element('img', {
         'class': 'url',
         'src': '../images/cms/icons/edit.png'
      }).addEvent('click', XManager.showEditPanel)
      .store('id', item.id));

      cell.grab(new Element('img', {
         'class': 'url',
         'src': '../images/cms/icons/config.png'
      }).addEvent('click', XManager.showConfigPanel)
      .store('id', item.id));

      cell.grab(new Element('img', {
         'class': 'url',
         'src': '../images/cms/icons/access.png'
      }).addEvent('click', XManager.showAccessPanel)
      .store('id', item.id));

      cell.grab(new Element('img', {
         'class': 'url',
         'src': '../images/cms/icons/remove.png'
      }).addEvent('click', XManager.removeTranslation)
      .store('id', item.id));

   },
   
   _getCategory: function(id) {
      
      var list = Array.filter(XManager._categories.toArray(), function(item) {
         
         if (item.xid == id) {
            return true;            
         }
         
      });
      
      return list.length ? list[0].name : '';
   }

});