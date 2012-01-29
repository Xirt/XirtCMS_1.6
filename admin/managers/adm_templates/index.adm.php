<?php

require_once('includes/Template.php');
require_once('includes/TemplateList.php');
require_once('includes/ContentViewer.php');
require_once('includes/ContentManager.php');

/**
 * Manager for XirtCMS templates
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

      XPage::addStylesheet('managers/adm_templates/css/main.css');
      XPage::addScript('managers/adm_templates/js/manager.js');
      XPage::addScript('managers/adm_templates/js/viewer.js');

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
         case "show_content_list":
            ContentViewer::showList();
            return;

         case "show_item":
            ContentViewer::showItem();
            return;

         /*
          * Modify methods
          */
         case "add_item":
            ContentManager::addItem();
            return;

         case "edit_item":
            ContentManager::editItem();
            return;

         case "edit_config":
            ContentManager::editConfiguration();
            return;

         case 'toggle_status':
            ContentManager::toggleStatus();
            return;

         case 'toggle_active':
            ContentManager::toggleActive();
            return;

         case "remove_item":
            ContentManager::removeItem();
            return;

      }

   }

}
?>