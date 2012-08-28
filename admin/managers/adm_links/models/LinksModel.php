<?php

/**
 * Models for SEF Links
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class LinksModel extends XContentList {

   /**
    * @var String with the name of the table containing the information
    */
   protected $_table = '#__links';


   /**
    * @var String The ordering column of the list (for database loading)
    */
   protected $_column = 'query';


   /**
    * @var Array The list of columns used for every item
    */
   protected $_columns = array('query', 'alternative', 'cid');


   /**
    * Loads list information from the database
    *
    * @param $iso The language to load (e.g. 'en-GB')
    * @return boolean True on succes, false on failure
    */
   public function load($iso = null) {
      return ($this->_table ? !$this->_load($iso) : false);
   }


   /**
    * Loads all content items from the database and adds them to the list
    * NOTE: Requires loading of all items for checks in LinkController
    *
    * @access private
    * @param $iso The language to load (e.g. 'en-GB')
    */
   private function _load($iso = null) {
      global $xConf, $xDb;

      $languageList = Xirt::getLanguages();
      $iso = array_key_exists($iso, $languageList) ? $iso : null;

      // Database query
      $query = 'SELECT *      ' .
               'FROM %s       ' .
               'ORDER BY %s %s';
      $query = sprintf($query, $this->_table, $this->_column, $this->_order);

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->execute();

      // Populate instance
      while ($dbRow = $stmt->fetchObject()) {

         if (is_null($iso) || $iso == $dbRow->iso) {
            $this->_add(new XItemModel($dbRow), false);
         }

      }

   }

}
?>