<?php

/**
 * Model for a XirtCMS User
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class UserModel extends XItemModel {

   /**
    * Loads item information from the database
    */
   public function load($id) {
      parent::loadFromDatabase('#__users', $id);
   }


   /**
    * Saves changes to the item to the database
    */
   public function add() {
      parent::addToDatabase('#__users');
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
   public function delete() {
      parent::deleteFromDatabase('#__users');
   }

}
?>