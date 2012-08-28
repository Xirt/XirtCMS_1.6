<?php

require_once('includes/Viewer.php');
require_once('includes/Manager.php');
require_once('includes/Template.php');
require_once('includes/search/Search.php');
require_once('includes/search/NormalSearch.php');
require_once('includes/search/FullTextSearch.php');

/**
 * Default component to show search results / form
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
      Viewer::showForm();
   }

}
?>