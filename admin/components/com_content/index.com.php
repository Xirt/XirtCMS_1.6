<?php

require_once('includes/Viewer.php');
require_once('includes/Manager.php');
require_once('includes/Template.php');

/**
 * Manager for XirtCMS static content viewer
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

      XPage::addStylesheet('components/com_content/css/main.css');
      XPage::addScript('components/com_content/js/main.js');

      Viewer::showTemplate();

   }


   /**
    * Handles any AJAX requests
    */
   function showAjax() {
      Manager::save();
   }

}
?>