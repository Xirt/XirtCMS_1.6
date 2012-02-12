<?php

/**
 * List containing instances of XItem (XirtCMS search term)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class TermList extends XContentList {

   /**
    * @var String Table with item information
    */
   var $table = '#__search';


   /**
    * @var String The ordering column of the list (for database loading)
    */
   var $column = 'impressions';


   /**
    * @var Array The list of columns used for every item
    */
   var $columns = array('term', 'uri', 'impressions');


   /**
    * Loads list information from the database
    *
    * @param $iso The language to load (e.g. 'en-GB')
    * @return boolean True on succes, false on failure
    */
   public function load($iso = null) {
      return ($this->table ? !$this->_load($iso) : false);
   }


   /**
    * Loads all content items from the database and adds them to the list
    *
    * @access private
    * @param $iso The language to load (e.g. 'en-GB')
    */
   private function _load($iso = null) {
      global $xConf, $xDb;

      $languageList = Xirt::getLanguages();
      $iso = array_key_exists($iso, $languageList) ? $iso : $xConf->language;

      // Database query
      $query = "SELECT * FROM %s WHERE language = :iso ORDER BY %s %s";
      $query = sprintf($query, $this->table, $this->column, $this->order);

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':iso', $iso);
      $stmt->execute();

      // Populate instance
      while ($dbRow = $stmt->fetchObject()) {
         $this->_add(new XItem($dbRow), false);
      }

   }

}
?>