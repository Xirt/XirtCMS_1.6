<?php

/**
 * Object containing details about a Twitter tweet
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2011 - 2012
 * @package    XirtCMS
 */
class Tweet extends XItem {

   /**
    * Loads item information from the database
    */
   public function load($id) {
      parent::loadFromDatabase('#__twitter', $id);
   }


   /**
    * Saves changes to the item to the database
    */
   public function save() {
      parent::saveToDatabase('#__twitter');
   }


   /**
    * Removes item from the database
    */
   public function remove() {
      parent::removeFromDatabase('#__twitter');
   }


   /**
    * Toggles publication status
    */
   public function toggleStatus() {

      $this->set('published', intval(!$this->published));
      $this->save();

   }

}
?>