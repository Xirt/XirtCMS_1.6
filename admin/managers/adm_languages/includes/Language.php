<?php

/**
 * Object containing details about a XirtCMS language
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class Language extends XItem {

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


   /**
    * Move item up the list
    */
   public function moveUp () {

      $this->preference--;
      if ($this->preference === 1) {
         $this->published = 1;
      }

      $this->save();

   }


   /**
    * Move item down the list
    */
   public function moveDown() {

      $this->preference++;
      $this->save();

   }


   /**
    * Toggles publication status
    */
   public function toggleStatus() {

      if (!($this->preference === 1 && $this->published)) {

         $this->published = intval(!$this->published);
         $this->save();

      }

   }


   /**
    * Removes item from the database
    */
   public function remove() {
      parent::removeFromDatabase('#__languages');
   }

}

?>