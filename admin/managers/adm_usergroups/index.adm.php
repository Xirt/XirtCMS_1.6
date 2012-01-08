<?php

require_once('includes/Translation.php');
require_once('includes/ContentList.php');
require_once('includes/TranslationList.php');
require_once('includes/ContentViewer.php');
require_once('includes/ContentManager.php');

/**
 * Manager for XirtCMS usergroups
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

      XContent::addCSSTag('managers/adm_usergroups/css/main.css');
      XContent::addScriptTag('managers/adm_usergroups/js/viewer.js');
      XContent::addScriptTag('managers/adm_usergroups/js/manager.js');

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
            ContentViewer::showContentList();
            return;

         case 'show_item':
            ContentViewer::showItem();
            return;

         case 'show_details':
            ContentViewer::showDetails();
            return;

         /*
          * Modify methods
          */
         case 'add_item':
            ContentManager::AddItem();
            return;

         case 'add_translation':
            ContentManager::AddTranslation();
            return;

         case 'edit_item':
            ContentManager::editItem();
            return;

         case 'remove_translation':
            ContentManager::removeTranslation();
            return;

      }

   }

}
?>
