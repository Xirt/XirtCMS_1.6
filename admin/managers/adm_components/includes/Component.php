<?php

/**
 * Object containing details about a XirtCMS component
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2011
 * @package    XirtCMS
 */
class Component extends XItem {

   /**
    * Loads item information from the database
    */
   public function load($id) {
      parent::loadFromDatabase('#__components', $id);
   }


   /**
    * Saves changes to the item to the database
    */
   public function save() {

      if ($this->id !== 1) {
         parent::saveToDatabase('#__components');
      }

   }

}
?>