<?php

/**
 * Extends the XTemplate class for use with manager XirtCMS templates
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 * @see        XTemplate
 */
class XAdminTemplate extends XTemplate {

   /**
    * Sets the default directories of Smarty when created
    *
    * @param $component The name of the current component
    */
   function __construct($component) {
      global $xConf;

      parent::__construct();

      // Modify instance for administrative usage
      $subdir = 'admin/managers/' . $component . '/templates/';
      $this->template_dir = $xConf->baseDir . $subdir;
      $this->compile_dir  = $xConf->baseDir . 'cache/';

   }

}
?>