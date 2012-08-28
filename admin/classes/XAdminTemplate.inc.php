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

      switch (substr($component, 0, 3)) {

         case "com":

            // Modify instance for administrative component
            $subdir = 'admin/components/' . $component . '/templates/';
            $this->template_dir = $xConf->baseDir . $subdir;
            $this->compile_dir  = $xConf->baseDir . 'cache/';

            break;

         case "adm":

            // Modify instance for administrative manager
            $subdir = 'admin/managers/' . $component . '/templates/';
            $this->template_dir = $xConf->baseDir . $subdir;
            $this->compile_dir  = $xConf->baseDir . 'cache/';

            break;

      }

   }

}
?>