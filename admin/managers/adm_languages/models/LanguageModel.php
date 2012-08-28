<?php

/**
 * Model for a XirtCMS Language
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class LanguageModel extends XItemModel {

   /**
    * Loads item information from the database
    */
   public function load($id) {
      parent::loadFromDatabase('#__languages', $id);
   }


   /**
    * Saves changes to the item to the database
    */
   public function save() {
      parent::saveToDatabase('#__languages');
   }

}
?>