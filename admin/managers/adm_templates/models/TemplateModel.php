<?php

/**
 * Model for a Template
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class TemplateModel extends XItemModel {

   /**
    * Loads item information from the database
    */
   public function load($id) {
      parent::loadFromDatabase('#__templates', $id);
   }


   /**
    * Saves changes to the item to the database
    */
   public function add() {
      parent::addToDatabase('#__templates');
   }


   /**
    * Saves changes to the item to the database
    */
   public function save() {
      parent::saveToDatabase('#__templates');
   }


   /**
    * Removes item from the database
    */
   public function delete() {
      parent::deleteFromDatabase('#__templates');
   }

}
?>