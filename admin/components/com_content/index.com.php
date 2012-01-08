<?php

require_once('includes/ViewManager.php');
require_once('includes/Template.php');

/**
 * Manager for XirtCMS static content viewer
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

      XContent::addCSSTag('components/com_content/css/main.css');
      XContent::addScriptTag('components/com_content/js/main.js');

      ViewManager::showTemplate();

   }


   /**
    * Handles any AJAX requests
    */
   function showAjax() {
      ViewManager::save();
   }

}
?>
