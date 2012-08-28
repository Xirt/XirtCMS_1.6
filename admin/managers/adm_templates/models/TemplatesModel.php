<?php

/**
 * Models for Templates
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class TemplatesModel extends XContentList {

   /**
    * @var String Table with item information
    */
   protected $_table = '#__templates';


   /**
    * @var String The ordering column of the list (for database loading)
    */
   protected $_column = 'active';


   /**
    * Saves all changes to the item to the database
    */
   public function save() {

      foreach ($this->_list as $item) {
         $item->saveToDatabase($this->_table);
      }

   }

}
?>