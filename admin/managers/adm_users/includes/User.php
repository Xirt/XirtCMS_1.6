<?php

/**
 * Object containing details about a XirtCMS user
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2011
 * @package    XirtCMS
 */
class User extends XItem {

   /**
    * Loads item information from the database
    */
   public function load($id) {

      parent::loadFromDatabase('#__users', $id);

   }


   /**
    * Saves changes to the item to the database
    */
   public function save() {

      parent::saveToDatabase('#__users');

   }


   /**
    * Removes item from the database
    */
   public function remove() {

      parent::removeFromDatabase('#__users');

   }

}
?>
