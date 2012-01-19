var BrowserNotification = new Class({

   initialize : function() {

      if (!Cookie.read('update')) {

         Asset.javascript('templates/xcss/xupdate.css');
         Cookie.write('update', '1');

         this._create();
         this.show();

      }

   },

   // Creates element
   _create : function() {

         this.fog = new Fog();
         this.container = new Element('div', {
            'class' : 'xUpdate'
         }).hide();

            this.container.grab(new Element('h1', {
               'text': XLang.update['header']
            }));
   
            this.container.grab(new Element('p', {
               'text': XLang.update['introduction']
            }));
   
            this.container.grab(new Element('p', {
               'text': XLang.update['download']
            }));        
   
            // Browser box
            var content = new Element('div');
   
               content.grab(new Element('a', {
                  'href'    : 'http://www.mozilla.com/firefox/',
                  'class'   : 'box-browser firefox',
                  'text'    : XLang.update['goFirefox'],
                  'target' : '_blank'
               }));
   
               content.grab(new Element('a', {
                  'href'    : 'http://www.google.com/chrome',
                  'class'   : 'box-browser chrome',
                  'text'    : XLang.update['goFirefox'],
                  'target' : '_blank'
               }));
   
               content.grab(new Element('a', {
                  'href'    : 'http://www.microsoft.com/windows/Internet-explorer/default.aspx',
                  'class'   : 'box-browser explorer',
                  'text'    : XLang.update['goExplorer'],
                  'target' : '_blank'
               }));
   
               content.grab(new Element('a', {
                  'href'    : 'http://www.apple.com/safari/download/',
                  'class'   : 'box-browser safari',
                  'text'    : XLang.update['goSafari'],
                  'target'  : '_blank'
               }));
   
               content.grab(new Element('a', {
                  'href'    : 'http://www.opera.com/download/',
                  'class'   : 'box-browser opera',
                  'text'    : XLang.update['goOpera'],
                  'target'  : '_blank'
               }));
   
               this.container.grab(content);
   
               this.container.grab(new Element('a', {
               'href'  : document.location,
               'class' : 'continue',
               'html'  : XLang.update['continue']
            }));

      this.container.inject($(document.body));

   },
   
   // Positions element
   _position : function() {

      this.container.position({
         position: 'center',
         offset: { x:0, y:-150 }
      });

   },

   // Shows element
   show : function() {

      this._position();
      this.container.show();
      this.fog.show();

   },

   // Hides element
   hide : function() {

      this.container.hide();
      this.fog.hidE();

   }

});
new BrowserNotification();
