<?php

require_once('includes/Viewer.php');
require_once('includes/Template.php');

/**
 * Component to initalize SitemapViewer
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

      switch (XTools::getParam('task')) {

         case 'use_xml':
            Viewer::showSitemapUseXML();
            break;

         default:
            Viewer::showSitemap();
            break;

      }

   }

}
?>