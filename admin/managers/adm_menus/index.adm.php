<?php

require_once('includes/Translation.php');
require_once('includes/TranslationList.php');
require_once('includes/ContentList.php');
require_once('includes/ContentViewer.php');
require_once('includes/ContentManager.php');

/**
 * Manager for XirtCMS menus
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

      XContent::addCSSTag('managers/adm_menus/css/main.css');
      XContent::addScriptTag('managers/adm_menus/js/viewer.js');
      XContent::addScriptTag('managers/adm_menus/js/manager.js');

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


         /*
          * Modify methods
          */
         case 'add_item':
            ContentManager::addItem();
            return;

         case 'add_translation':
            ContentManager::addTranslation();
            return;

         case 'edit_item':
            ContentManager::editItem();
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