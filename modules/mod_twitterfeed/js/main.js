var TwitterFeed = new Class({

   current: null,

   // Initializes the twitterbox (scrolling / coloring)
   initialize: function(box) {

      this.box = $(box);
      this.load();

   },

   // Loads the tweets 
   load: function() {

      new Request.JSON({
         onSuccess: this._receive.bind(this),
         url: 'index.php'
      }).post({
         content: 'mod_twitterfeed',
         task: 'show_twitter'
      });

   },

   // Receives the tweets 
   _receive: function(json) {

      this.box.empty();
      this.scroll();

      json.reverse();
      Array.each(json, function(tweet, key) {
         this._show(tweet, !key);
      }, this);

   },

   // Shows a tweet
   _show: function(tweet, last) {

      var box = new Element('div', {
         'class' : (last ? 'tweet last' : 'tweet') + ' tweet-' + tweet.id
      });

         // Avatar (image / link)
         var link = new Element('a', {
            'href'   : 'http://www.twitter.com/' + tweet.account,
            'target' : '_blank',
            'class'  : 'image'
         });

            new Element('img', {
               'src' : tweet.avatar,
               'alt' : tweet.author
            }).inject(link);

         link.inject(box);

         // Content (text / author / created)
         var content = new Element('div', {
            'class': 'tweet-content'
         });

            new Element('p', {
               'html'  : tweet.content,
               'class' : 'tweet'
            }).inject(content);

            new Element('span', {
               'text': tweet.author + ' (' + tweet.created + ')',
               'class' : 'author'
             }).inject(content);

         content.inject(box);

      box.inject(this.box, 'top');

   },

   // Initializes the scrolling of the box
   scroll: function() {

      this.scroll = new Fx.Scroll(this.box, {
         duration: 1000,
         wait: false
      });

      this.doScroll();

   },

   // Execution of scrolling movement
   doScroll: function() {

      if (!this.current || !this.current.getNext()) {
         this.current = this.box.getElement('.tweet');
      } else {
         this.current = this.current.getNext();
      }

      if (this.current) {
         this.scroll.toElement(this.current);
      }

      (function() {
         this.doScroll();
      }).delay(5000, this);

   }

});

window.addEvent('domready', function() {
   new TwitterFeed('x-feed');
});
