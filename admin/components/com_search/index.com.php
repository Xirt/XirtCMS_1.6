<?php

require_once('includes/Term.php');
require_once('includes/Viewer.php');
require_once('includes/Manager.php');
require_once('includes/Template.php');
require_once('includes/TermList.php');


/**
 * Manager for XirtCMS links
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Component extends XComponent {

   /**
    * Handles any normal requests
    */
   function showNormal() {

      XPage::addStylesheet('components/com_search/css/main.css');
      XPage::addScript('components/com_search/js/manager.js');
      XPage::addScript('components/com_search/js/viewer.js');

      Viewer::showTemplate();

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
            Viewer::showList();
            return;

         case 'show_item':
            Viewer::showItem();
            return;


            /*
             * Modify methods
             */
         case 'add_item':
            Manager::addItem();
            return;

         case 'edit_item':
            Manager::editItem();
            return;

         case 'remove_item':
            Manager::removeItem();
            return;

      }

   }

}
?>