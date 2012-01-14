<?php

require_once("includes/Viewer.php");
require_once("includes/Template.php");
require_once("includes/Thumbnail.php");

/**
* Component to access utility methods
*
* @author     A.G. Gideonse
* @version    1.6
* @copyright  XirtCMS 2011 - 2012
* @package	  XirtCMS
*/
class Component extends XComponent {

   /**
   * Handles any normal requests
   */
   function showNormal() {

      switch (XTools::getParam('task')) {

         case 'thumbnail':
            new Thumbnail();
            break;

         case 'no_javascript':
            Viewer::showNoJavaScript();
            break;

      }

   }

}
?>