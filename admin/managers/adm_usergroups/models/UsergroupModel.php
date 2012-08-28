<?php

/**
 * Model for a XirtCMS Usergroup
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class UsergroupModel extends XItemModel {

   /**
    * Loads item information from the database
    */
   public function load($id) {
      parent::loadFromDatabase('#__usergroups', $id);
   }


   /**
    * Saves changes to the item to the database
    */
   public function add() {
      parent::addToDatabase('#__usergroups');
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
   public function delete() {
      parent::deleteFromDatabase('#__usergroups');
   }

}
?>