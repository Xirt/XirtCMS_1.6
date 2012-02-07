<?php

require_once('smarty/Smarty.class.php');

/**
 * Extends the Smarty class for use with default XirtCMS templates
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XTemplate extends Smarty {

   /**
    * @var The default location for components
    */
   const COMPONENTS = '%s/components/%s/templates/';


   /**
    * @var The default location for modules
    */
   const MODULES = '%s/modules/%s/templates/';


   /**
    * CONSTRUCTOR
    */
   function __construct($dir = null) {
      global $xConf;

      parent::__construct();

      $this->template_dir = isset($dir) ? $dir : $xConf->baseDir;
      $this->compile_dir  = $xConf->baseDir . 'cache/';

   }

}
?>