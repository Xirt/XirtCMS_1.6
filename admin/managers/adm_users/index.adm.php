<?php

require_once('includes/User.php');
require_once('includes/UserList.php');

require_once('includes/ContentViewer.php');
require_once('includes/ContentManager.php');

/**
 * Manager for XirtCMS users
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2011
 * @package	   XirtCMS
 */
class Manager extends XComponent {

   /**
    * Handles any normal requests
    */
   function showNormal() {

      XContent::addCSSTag('managers/adm_users/css/main.css');
      XContent::addScriptTag('managers/adm_users/js/viewer.js');
      XContent::addScriptTag('managers/adm_users/js/manager.js');

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
         case 'add_item':
            ContentManager::AddItem();
            return;

         case 'edit_item':
            ContentManager::editItem();
            return;

         case 'reset_password':
            ContentManager::resetPassword();
            return;

         case 'remove_item':
            ContentManager::removeItem();
            return;

      }

   }

}
?>
