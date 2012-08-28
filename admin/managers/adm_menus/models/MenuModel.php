<?php

/**
 * Model for a XirtCMS Menus
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class MenuModel extends XItemModel {

   /**
    * Loads item information from the database
    */
   public function load($id) {
      parent::loadFromDatabase('#__menus', $id);
   }


   /**
    * Saves changes to the item to the database
    */
   public function add() {
      parent::addToDatabase('#__menus');
   }


   /**
    * Saves changes to the item to the database
    */
   public function save() {
      parent::saveToDatabase('#__menus');
   }


   /**
    * Removes item from the database
    */
   public function delete() {
      parent::deleteFromDatabase('#__menus');
   }

}
?>