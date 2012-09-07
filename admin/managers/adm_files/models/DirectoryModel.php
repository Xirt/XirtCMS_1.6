<?php

/**
 * A simple list to hold a directory structure (contents)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class DirectoryModel extends XModel {

   /**
    * @var The list of items
    */
   private $_list = array();


   /**
    * Loads the complete directory structure into the list
    *
    * @access private
    */
   public function load($path) {
      global $xCom;

      $this->path = $path;

      if ($this->path != './') {

         $dir = new Dir(dirname($this->path));
         $dir->name = $xCom->xLang->misc['parent'];
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


   /**
    * Returns the model (including hash) as Array
    *
    * @return Array The model as Array
    */
   public function toArray() {
      return $this->_list;
   }

}
?>