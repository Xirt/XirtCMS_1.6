<?php

/**
 * Component to access utility methods
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2011 - 2012
 * @package    XirtCMS
 */
class Component extends XComponent {

   /**
    * Handles any normal requests
    */
   function showNormal() {

      switch (XTools::getParam('task')) {

         case 'thumbnail':
            new ImageController(null, null, 'thumbnail');
            break;

         case 'no_javascript':
            new PanelController(null, 'NoJavascriptView', 'show');
            break;

      }

   }

}
?>