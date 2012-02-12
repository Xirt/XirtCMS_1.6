<?php

/**
 * List containing simple instances of Item
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XTranslationList {

   /**
    * @var Integer The integer of the items in the list
    */
   var $xId = 0;


   /**
    * @var String with the name of the table containing the information
    */
   protected $_table = null;


   /**
    * @var Array containing all items
    */
   protected $_list = array();


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
    * @param $xId Integer with the xId of the items in the list
    */
   private function _load($xId) {
      global $xDb;

      // Database query
      $stmt = "SELECT * FROM (%s) AS subset WHERE xid = :xid ORDER BY xid";
      $subs = "SELECT t1.* FROM {$this->_table} AS t1 INNER JOIN #__languages AS t2 ON t1.language = t2.iso ORDER BY t2.preference, t1.xid";

      // Retrieve data
      $stmt = $xDb->prepare(sprintf($stmt, $subs));
      $stmt->bindParam(':xid', $xId, PDO::PARAM_INT);
      $stmt->execute();

      // Populate instance
      while ($dbRow = $stmt->fetchObject()) {
         $this->_add(new XItem($dbRow), false);
      }

   }



   /***********/
   /*  MODIFY */
   /***********/

   /**
    * Sets an attribute for all translation in the list
    *
    * @param $attrib The variable to set
    * @param $value The value for the given variable
    */
   public function set($attrib, $value) {

      foreach ($this->_list as $translation) {

         $translation->set($attrib, $value);
         $translation->saveToDatabase($this->_table);

      }

   }


   /**
    * Adds a new item
    *
    * @param $item The item to add
    * @return boolean True
    */
   public function add($item) {
      return $this->_add($item);
   }


   /**
    * Adds an item
    *
    * @param $item The item to add
    * @param $doSave Toggles saving to the preconfigured database (optional)
    * @return boolean true
    */
   public function _add($item, $doSave = true) {
      global $xDb;

      if ($this->_table && $doSave) {
         $xDb->insert($this->_table, $item);
      }

      return ($this->_list[] = $item);
   }



   /*****************/
   /* MISCELLANEOUS */
   /*****************/


   /**
    * Returns all items in the list
    *
    * @return Array All items in the list
    */
   public function toArray() {
      return $this->_list;
   }


   /**
    * Returns the amount of items in the list
    *
    * @return Int The amount of items in the list
    */
   public function count() {
      return count($this->_list);
   }


   /**
    * Returns list as a JSON Object
    */
   public function encode() {
      return json_encode($this->_list);
   }


   /**
    * Shows list as JSON Object
    */
   public function show() {

      header('Content-type: application/x-json');
      die($this->encode());

   }

}
?>