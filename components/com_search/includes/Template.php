<?php

/**
 * Extends the Smarty class for use with default XirtCMS templates
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Template extends XTemplate {

   /**
    * Sets the default directories of Smarty when created
    */
   function __construct() {
      global $xConf;

      parent::__construct();

      $templates = sprintf(self::COMPONENTS, $xConf->baseDir, 'com_search');
      $this->template_dir = $templates;

   }

}
?>