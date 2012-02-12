<?php

require_once('includes/Translation.php');
require_once('includes/ContentList.php');
require_once('includes/TranslationList.php');
require_once('includes/ContentViewer.php');
require_once('includes/ContentManager.php');

/**
 * Manager for XirtCMS static content
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

      XPage::addStylesheet('managers/adm_content/css/main.css');
      XPage::addScript('managers/adm_content/js/viewer.js');
      XPage::addScript('managers/adm_content/js/manager.js');

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

         case 'show_category_list':
            ContentViewer::showCategoryList();
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
         case 'add_content':
            ContentManager::AddItem();
            return;

         case 'add_translation':
            ContentManager::addTranslation();
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