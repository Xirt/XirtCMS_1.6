<?php

require_once('includes/Translation.php');
require_once('includes/TranslationList.php');
require_once('includes/ContentList.php');
require_once('includes/ContentViewer.php');
require_once('includes/ContentManager.php');

/**
* Manager for XirtCMS content categories
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

      XContent::addCSSTag('managers/adm_categories/css/main.css');
      XContent::addScriptTag('managers/adm_categories/js/viewer.js');
      XContent::addScriptTag('managers/adm_categories/js/manager.js');

      ContentViewer::showTemplate();

   }

   /**
    * Handles any AJAX requests
    */
   function showAjax() {

      switch (XTools::getParam('task')) {

         case 'show_content_list':
            ContentViewer::showContentList();
            return;

         case 'show_item':
         case 'show_details':
            ContentViewer::showItem();
            return;

         case 'add_item':
            ContentManager::AddItem();
            return;

         case 'add_translation':
            ContentManager::AddTranslation();
            return;

         case 'edit_item':
            ContentManager::editItem();
            return;

         case 'edit_config':
            ContentManager::editConfiguration();
            return;

         case 'edit_access':
            ContentManager::editAccess();
            return;

         case 'move_down':
            ContentManager::moveDown();
            return;

         case 'move_up':
            ContentManager::moveUp();
            return;

         case 'toggle_sitemap':
            ContentManager::toggleSitemap();
            return;

         case 'toggle_mobile':
            ContentManager::toggleMobile();
            return;

         case 'toggle_status':
            ContentManager::toggleStatus();
            return;

         case 'remove_translation':
            ContentManager::removeTranslation();
            return;

      }

   }

}
?>
