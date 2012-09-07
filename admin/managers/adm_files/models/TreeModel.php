<?php

/**
 * A simple list to hold the total XirtCMS directory structure
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class TreeModel extends XModel {

   /**
    * @var The list of items
    */
   private $_list = array();


   /**
    * Loads the complete directory structure into the list
    *
    * @access private
    */
   public function load() {

      $dir = new XDir('.');
      $this->_list = $dir->summarize(false, true);
      array_unshift($this->_list, './');

   }


   /**
    * Returns the model (including hash) as Array
    *
    * @return Array The model as Array
    */
   public function toArray() {

      return array(
         'hash' => md5(serialize($this->_list)),
         'tree' => $this->_list
      );

   }

}
?>