<?php

/**
 * Component to manage saved Twitter tweets
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2011 - 2012
 * @package	   XirtCMS
 */
class Component extends XComponent {

   /**
    * Handles any normal requests
    */
   function showNormal() {
      new PanelController('PanelModel', 'PanelView', 'show');
   }


   /**
    * Handles any AJAX requests
    */
   function showAjax() {

      switch (XTools::getParam('task')) {

         /*
          * View methods
          */
         case 'show_content_list':
            new TweetsController('TweetsModel', 'TweetsView', 'show');
            return;

         case 'show_item':
            new TweetController('TweetModel', 'TweetView', 'show');
            return;

         /*
          * Modify methods
          */
         case 'toggle_status':
            new TweetController('TweetModel', null, 'toggleStatus');
            return;

         case 'remove_item':
            new TweetController('TweetModel', null, 'delete');
            return;

      }

   }

}
?>