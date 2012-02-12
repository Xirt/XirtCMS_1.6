<?php

require_once('includes/Link.php');
require_once('includes/LinkList.php');

require_once('includes/ContentViewer.php');
require_once('includes/ContentManager.php');

/**
 * Manager for XirtCMS links
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Manager extends XComponent {

   /**
    * Handles any normal requests
    */
   function showNormal() {

      XPage::addStylesheet('managers/adm_links/css/main.css');
      XPage::addScript('managers/adm_links/js/manager.js');
      XPage::addScript('managers/adm_links/js/viewer.js');

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
            ContentManager::addItem();
            return;

         case 'edit_item':
            ContentManager::editItem();
            return;

         case 'remove_item':
            ContentManager::removeItem();
            return;
      }

   }

}
?>