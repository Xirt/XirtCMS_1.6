<?php

/**
 * A model to manage a directory
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class DirectoryModel extends XDir {

   /**
    * Placeholder (overwrites default)
    */
   function __construct() {
   }


   /**
    * Initializes object with details about the directory
    *
    * @param $path The path to the directory
    */
   public function load($path) {
      parent::__construct($path);
   }

}
?>