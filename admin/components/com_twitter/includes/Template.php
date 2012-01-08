<?php

/**
 * Extends the Smarty class (through XTemplate) for use within this component
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

      parent::__construct();

      $parentDir = realpath(dirname(__FILE__) . '/../');
      $this->template_dir = $parentDir . '/templates/';

   }

}
?>