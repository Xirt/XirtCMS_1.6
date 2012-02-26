<?php

/**
 * A simple list to hold the total XirtCMS directory structure
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class DirectoryTree {

   /**
    * @var The list of items
    */
   private $_list = array();


   /**
    * Create a list of the current XirtCMS directory structure
    */
   function __construct() {
      $this->_init();
   }


   /**
    * Loads the complete directory structure into the list
    *
    * @access private
    */
   private function _init() {

      $dir = new XDir('.');
      $this->_list = $dir->summarize(false, true);
      array_unshift($this->_list, './');

   }


   /*****************/
   /* MISCELLANEOUS */
   /*****************/

   /**
    * Returns list as a JSON Object
    */
   public function encode() {

      return json_encode(array(
         'hash' => md5(serialize($this->_list)),
         'tree' => $this->_list
      ));

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