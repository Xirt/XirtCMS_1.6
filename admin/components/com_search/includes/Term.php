<?php

/**
 * Object containing details about a XirtCMS search term
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Term extends XItem {

   /**
    * Loads item information from the database
    */
   public function load($id) {

      parent::loadFromDatabase('#__search', $id);

   }


   /**
    * Saves changes to the item to the database
    */
    public function save() {

       parent::saveToDatabase('#__search');

    }


   /**
    * Removes item from the database
    */
   public function remove() {

      parent::removeFromDatabase('#__search');

   }

}
?>
