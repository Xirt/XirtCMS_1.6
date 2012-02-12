<?php

require_once('includes/Tweet.php');
require_once('includes/Viewer.php');
require_once('includes/Manager.php');
require_once('includes/Template.php');
require_once('includes/TweetList.php');

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

      XPage::addStylesheet('components/com_twitter/css/main.css');
      XPage::addScript('components/com_twitter/js/viewer.js');
      XPage::addScript('components/com_twitter/js/manager.js');

      Viewer::showTemplate();

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
            Viewer::showList();
            return;

         case 'show_item':
            Viewer::showItem();
            return;

         /*
          * Modify methods
          */
         case 'toggle_status':
            Manager::toggleStatus();
            return;

         case 'remove_item':
            Manager::removeItem();
            return;

      }

   }

}
?>