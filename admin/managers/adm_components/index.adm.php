<?php

require_once('includes/Component.php');
require_once('includes/ComponentList.php');
require_once('includes/ContentViewer.php');
require_once('includes/ContentManager.php');

/**
 * Manager for XirtCMS components
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2011
 * @package    XirtCMS
 */
class Manager extends XComponent {

   /**
    * Handles any normal requests
    */
   function showNormal() {

      XPage::addStylesheet('managers/adm_components/css/main.css');
      XPage::addScript('managers/adm_components/js/viewer.js');
      XPage::addScript('managers/adm_components/js/manager.js');

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
         case 'edit_access':
            ContentManager::editAccess();
            return;

      }

   }

}
?>