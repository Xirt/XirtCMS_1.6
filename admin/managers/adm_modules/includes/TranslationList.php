<?php

/**
 * List containing simple instances of Translation
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class TranslationList extends XTranslationList {

   /**
    * @var String with the name of the table containing the information
    */
   protected $_table = '#__modules';


   /**
    * Loads list information from the database
    * NOTE: This method is required to call the _new_ method $this->_load();
    *
    * @param $xId Integer with the xId of the items in the list
    * @return boolean True on succes, false on failure
    */
   public function load($xId) {
      return ($this->_table ? !$this->_load($xId) : false);
   }


   /**
    * Loads all content items from the database and adds them to the list
    *
    * @access private
    * @param $xId The xID of the item in the database
    */
   private function _load($xId) {
      global $xDb;

      // Query (selection)
      $query = 'SELECT id, xid, type, config, access_min, access_max ' .
               'FROM (%s) AS subset                                  ' .
      		   'WHERE xid = :xid                                     ' .
               'ORDER BY preference                                  ';

      // Subquery (translations)
      $trans = 'SELECT t1.*, t2.preference                           ' .
               'FROM %s AS t1                                        ' .
               'INNER JOIN #__languages AS t2                        ' .
               'ON t1.language = t2.iso                              ' .
               'ORDER BY t2.preference, t1.xid                       ';
      $trans = sprintf($trans, $this->_table);

      // Retrieve data
      $stmt = $xDb->prepare(sprintf($query, $trans));
      $stmt->bindParam(':xid', $xId, PDO::PARAM_INT);
      $stmt->execute();

      // Populate instance
      while ($dbRow = $stmt->fetchObject()) {
         $this->_add(new Translation($dbRow), false);
      }

   }


   /**
    * Adds a new item
    *
    * @param $item The item to add
    * @return boolean True
    */
   public function add($item) {

      $item->config = json_encode($item->config);

      return $this->_add($item);
   }

}
?>