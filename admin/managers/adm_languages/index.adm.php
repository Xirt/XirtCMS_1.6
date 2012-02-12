<?php

require_once('includes/Language.php');
require_once('includes/LanguageList.php');

require_once('includes/ContentViewer.php');
require_once('includes/ContentManager.php');

/**
 * Manager for XirtCMS languages
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package	   XirtCMS
 */
class Manager extends XComponent {

   /**
    * Handles any normal requests
    */
   function showNormal() {

      XPage::addStylesheet('managers/adm_languages/css/main.css');
      XPage::addScript('managers/adm_languages/js/viewer.js');
      XPage::addScript('managers/adm_languages/js/manager.js');

      ContentViewer::showTemplate();

   }

   /**
    * Handles any AJAX requests
    */
   function showAjax() {

      switch (XTools::getParam("task")) {

         /*
          * View methods
          */
         case 'show_content_list':
            ContentViewer::showList();
            return;


            /*
             * Modify methods
             */
         case 'move_down':
            ContentManager::moveDown();
            return;

         case 'move_up':
            ContentManager::moveUp();
            return;

         case 'toggle_status':
            ContentManager::toggleStatus();
            return;

      }

   }

}
?>