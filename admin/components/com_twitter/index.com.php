<?php

require_once('includes/Tweet.php');
require_once('includes/Template.php');
require_once('includes/TweetList.php');
require_once('includes/ContentViewer.php');
require_once('includes/ContentManager.php');

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

      XContent::addCSSTag('components/com_twitter/css/main.css');
      XContent::addScriptTag('components/com_twitter/js/viewer.js');
      XContent::addScriptTag('components/com_twitter/js/manager.js');

      ContentViewer::showTemplate();

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
            ContentViewer::showList();
            return;

         case 'show_item':
            ContentViewer::showItem();
            return;

         /*
          * Modify methods
          */
         case 'toggle_status':
            ContentManager::toggleStatus();
            return;

         case 'remove_item':
            ContentManager::removeItem();
            return;

      }

   }

}
?>