<?php

require_once('includes/Template.php');

require_once('includes/Term.php');
require_once('includes/TermList.php');

require_once('includes/ContentViewer.php');
require_once('includes/ContentManager.php');

/**
 * Manager for XirtCMS links
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2011
 * @package    XirtCMS
 */
class Component extends XComponent {

   /**
    * Handles any normal requests
    */
   function showNormal() {

      XContent::addCSSTag('components/com_search/css/main.css');
      XContent::addScriptTag('components/com_search/js/manager.js');
      XContent::addScriptTag('components/com_search/js/viewer.js');

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
