<?php

require_once('includes/ConfigManager.php');
require_once('includes/Template.php');


/**
 * Manager used to modify the configuration of the website
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2011
 * @package	  XirtCMS
 */
class Manager extends XComponent {

   /**
    * Handles any normal requests
    */
   function showNormal() {

      XPage::addStylesheet('managers/adm_config/css/main.css');
      XPage::addScript('managers/adm_config/js/main.js');

      ConfigManager::showTemplate();
   }

   /**
    * Handles any AJAX requests
    */
   function showAjax() {

      switch (XTools::getParam('task')) {

         case "save":
            ConfigManager::save();
            break;

         default:
            break;

      };
   }
}
?>