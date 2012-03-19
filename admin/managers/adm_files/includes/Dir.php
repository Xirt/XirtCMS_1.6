<?php

/**
 * Object containing details about a directory
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Dir extends XDir {

   /**
    * @var The type of the instance (compatibility with files)
    */
   var $type = 'folder';


   /**
    * Initializes object with details about the file / directory
    *
    * @param $path The path to the directory
    */
   function __construct($path) {

      parent::__construct($path);
      $this->_init();

   }


   /**
    * Initializes the instance for a file
    *
    * @param $path The path to the file
    */
   private function _init() {

      $this->type     = $this->_getType();
      $this->writable = is_writable($this->path);
      $this->chmod    = $this->getPermissions();

   }


   /**
    * Returns the chmod of the item
    *
    * @return Int The current CHMOD of the item
    */
   public function getPermissions() {

      if (substr(PHP_OS, 0, 3) == 'WIN') {
         return -1;
      }

      return substr(decoct(fileperms($this->path)), -3);
   }


   /*****************/
   /* MISCELLANEOUS */
   /*****************/

   /**
    * Returns list as a JSON Object
    */
   public function encode() {
      return json_encode($this);
   }


   /**
    * Shows list as JSON Object
    */
   public function show() {

      header('Content-type: application/x-json');
      die($this->encode());

   }

}
?>