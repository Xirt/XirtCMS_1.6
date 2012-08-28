<?php

/**
 * Model for a XirtCMS Components
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ComponentModel extends XItemModel {


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
      parent::saveToDatabase('#__components');
   }

}
?>