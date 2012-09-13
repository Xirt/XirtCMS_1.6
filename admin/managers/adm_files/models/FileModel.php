<?php

/**
 * A model to manage a file
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class FileModel extends XFile {

   /**
    * Placeholder (overwrites default)
    */
   function __construct() {
   }


   /**
    * Initializes object with details about the file
    *
    * @param $path The path to the file
    * @param $file The name of the file
    */
   public function load($path, $file) {
      parent::__construct($path, $file);
   }

}
?>