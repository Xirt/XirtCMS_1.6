<?php

/**
 * A simple list to hold items of a directory (XFile / XDir)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class DirectoryList {

   /**
    * @var The list of items
    */
   private $_list = array();


   /**
    * Create a list of the given directory
    *
    * @param $path The path of the indexed directory
    */
   public function __construct($path) {

      $this->path = $path;
      $this->_init();

   }


   /**
    * Loads the content of the directory into the instance
    *
    * @access private
    */
   private function _init() {

      if ($this->path != './') {

         $dir = new Dir(dirname($this->path));
         $dir->name = 'Parent Directory';
         $dir->type = 'parent';
         $this->add($dir);

      }

      $dir = new XDir($this->path);
      foreach ($dir->summarize(true, false) as $item) {

         if (is_file($item) && basename($item)) {
            $this->add(new File($dir->path, basename($item)));
         }

         if (is_dir($item) && basename($item)) {
            $this->add(new Dir($item));
         }

      }

   }


   /**
    * Adds the given item to the current list
    *
    * @param $item The item to add
    */
   public function add($item) {

      $this->_list[] = $item;

   }


   /*****************/
   /* MISCELLANEOUS */
   /*****************/

   /**
    * Returns list as a JSON Object
    */
   public function encode() {
      return json_encode($this->_list);
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