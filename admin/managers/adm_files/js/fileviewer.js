var FileViewer = new Class({

	Implements: [Events, Options],

	_path: './',
   _fade: false,

   // Create a new directory view
   initialize: function(el, options) {

      this.container = $(el);
      this.load(this._path, true);

   },

   // Loads directory content
   load: function(path, noFade) {

      this._fade = noFade ? false : true;
      this._path = path;

      new Request.JSON({
         onFailure: Xirt.showError,
         onSuccess: this._receive.bind(this),
         url: 'index.php'
      }).post({
         content: XManager.component,
         task: 'show_directory',
         dir: path
      });

   },

   // Reloads directory content
   reload: function() {
      this.load(this._path);
   },

   // Shows directory content
   _receive: function(json) {

      this.container.empty();
      Array.each(json, function (item, key) {
      	
         var item = this._getIcon(item);
         this.container.grab(item);
         item.fade(this._fade ? 'in' : 'show');

      }, this);

      Slimbox.scanPage();
   },
   
   // Returns icon for given item
   _getIcon: function(item) {
   	
   	switch(item.type) {
   		
   		case 'folder':
   		case 'parent':
   			return new Folder(item);
   			break;
   			
   		case 'image':
   			return new Thumbnail(item);
   			break;

   	}

		return new XIcon(item);
   }

});


/**
 * Class for creating icons
 */
var XIcon = new Class({

	_icon : '../images/cms/filetypes/{type}.png',
	
   // Creates a new file / folder icon
   initialize: function(item) {

      this.element = new Element('div', {
         'class': 'box-file'
      });

   	this.element.grab(this._getTitle(item.name));
      this.element.grab(this._getIcon(item));
      this.element.grab(this._getOptions(item));
      this.fade('hide');

   },
   
   // Returns the title component of the icon
   _getTitle: function(title) {

      return new Element('abbr', {
         'text': title,
         'title': title
      });

   },

   // Returns the content component of the icon
   _getIcon: function(item) {

      return new Element('img', {
         'src': this._icon.substitute({'type': item.type }),
         'class': 'icon',
         'title': item.name
      });

   },

   // Returns the options box for the icon
   _getOptions: function(item) {
   	
   	if (!['parent', 'folder'].contains(item.type)) {
   		item.path = item.path + item.name;   		
   	}
   	
      return this._getOptionsBox(item);
   },
   
   // Returns the options box for the icon   
   _getOptionsBox: function(item) {
   	
      var oDv = new Element('div', {
         'class': 'box-options'
      });

      if (item.writable && item.type != 'parent') {

         oDv.grab(new Element('img', {
            'src': '../images/cms/icons/remove.png'
         }).store('path', item.path)
         .addEvent('click', XManager.remove));

         oDv.grab(new Element('img', {
            'src': '../images/cms/icons/edit.png'
         }).store('path', item.path)
         .addEvent('click', XManager.showEditPanel));

      }

      return oDv;

   },

   // Handles clicks (default)
	_onClick: function(event) {
		event.stop();
	},

   // Returns the current element
   toElement: function() {
      return this.element;
   },
   
   // Fades the current element
   fade: function(type) {
   	return this.element.fade(type);
   }

});


/**
 * Class for creating icons
 */
var Folder = new Class({

	Extends: XIcon,

   _getIcon: function(item) {

   	var el = new Element('img', {
         'src'   : this._icon.substitute({'type': item.type }),
	      'title' : item.name,
	      'class' : 'icon clickable'
	   });

      el.addEvent('click', this._onClick);
      el.path = item.path;

      return el;
   },
 
   // Handles clicks
	_onClick: function(event) {

		XTreeViewer.chdir(this.path);
		event.stop();

	}

});


/**
 * Class for creating icons
 */
var Thumbnail = new Class({

	Extends : XIcon,
	_icon   : 'managers/adm_files/thumbnail.php?img={image}',
	
   _getIcon: function(item) {

      var link = new Element('a', {
         'href' : '../' + item.file,
      	'rel'  : 'lightbox'
      });

	   return link.grab(new Element('img', {
         'src'   : this._icon.substitute({'image': item.file }),
	      'title' : item.dimensions,
	      'class' : 'icon'
	   }));

   }

});