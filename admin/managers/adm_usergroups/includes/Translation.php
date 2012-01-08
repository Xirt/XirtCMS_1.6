<?php

/**
 * Object containing details about a XirtCMS usergroup (translation)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2011
 * @package    XirtCMS
 */
class Translation extends XItem {

   /**
    * @var Toggles removability of the item
    */
   var $removable = true;


   /**
    * Loads item information from the database
    *
    * @param $id The ID of the item in the database
    */
   public function load($id) {

      parent::loadFromDatabase('#__usergroups', $id);

   }


   /**
    * Saves changes to the item to the database
    */
   public function save() {

      parent::saveToDatabase('#__usergroups');

   }


   /**
    * Removes item from the database
    */
   public function remove() {

      if ($this->id && $this->removable) {
         parent::removeFromDatabase('#__usergroups');
      }

   }

}
?>
