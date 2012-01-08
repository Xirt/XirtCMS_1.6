<?php

/**
 * List containing instances of Language (XirtCMS languages)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2011
 * @package    XirtCMS
 */
class LanguageList extends XContentList {

   /**
    * @var String Table with item information
    */
   var $table = '#__languages';


   /**
    * Loads list information from the database
    *
    * @return boolean True on succes, false on failure
    */
   public function load() {
      return ($this->table ? !$this->_load() : false);
   }


   /**
    * Loads all content items from the database and adds them to the list
    *
    * @access private
    */
   private function _load() {
      global $xDb;

      $query = "SELECT *
                FROM {$this->table}
                ORDER BY preference ASC";
      $xDb->setQuery($query);

      foreach ($xDb->loadObjectList() as $dbRow) {
         $this->_add(new Language($dbRow), false);
      }

   }


   /**
    * Move item up the list
    *
    * @return boolean True on success, false on failure
    */
   public function moveUp($id) {

      $item = $this->getItemByAttribute('id', $id);
      $prev = $this->getItemByAttribute('preference', $item->preference - 1);

      if ($item && $prev) {

         $prev->moveDown();
         $item->moveUp();
         return true;

      }

      return false;
   }


   /**
    * Move item down the list
    *
    * @return boolean True on success, false on failure
    */
   public function moveDown($id) {

      $item = $this->getItemByAttribute('id', $id);
      $next = $this->getItemByAttribute('preference', $item->preference + 1);

      if ($item && $next) {

         $item->moveDown();
         $next->moveUp();
         return true;

      }

      return false;
   }

}
?>
