<?php

/**
 * List containing simple instances of Item
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XContentList {

   /**
    * @var String with the name of the table containing the information
    */
   var $table = null;


   /**
    * @var Integer The start of the list (for database loading)
    */
   var $start = 0;


   /**
    * @var Integer The limit of the list (for database loading)
    */
   var $limit = 0;


   /**
    * @var String The ordering column of the list (for database loading)
    */
   var $column = 'id';


   /**
    * @var String The order of the list (for database loading: DESC / ASC)
    */
   var $order = 'DESC';


   /**
    * @var Array The list of columns used for every item
    */
   var $columns = array();


   /**
    * @var Array containing all items
    */
   var $list = array();


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
                ORDER BY {$this->column} {$this->order}";
      $xDb->setQuery($query);

      foreach ($xDb->loadObjectList() as $dbRow) {
         $this->_add(new XItem($dbRow), false);
      }

   }



   /***********/
   /*  MODIFY */
   /***********/

   /**
   * Sets a the start of the items in the database
   *
   * @param $start Integer defining the start of the list
   */
   public function setStart($start) {
      $this->start = ($start > 0) ? $start : 0;
   }


   /**
    * Sets a limit on the items in the list
    *
    * @param $limit Integer with the maximum number to show
    */
   public function setLimit($limit) {
      $this->limit = $limit ? $limit : 1;

   }


   /**
    * Sets a column to sort the list on
    *
    * @param $column The column to sort on (must exist!)
    */
   public function setColumn($column) {

      if (in_array($column, $this->columns)) {
         $this->column = $column;
      }

   }


   /**
    * Sets the order of the sorting process
    *
    * @param $order The ordering (DESC or ASC)
    */
   public function setOrder($order) {

      if (in_array($order, array("DESC", "ASC"))) {
         $this->order = $order;
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
    * Adds an item to the internal list
    *
    * @param $item The item to add
    * @param $saveToDatabase Toggles saving to the database (optional)
    * @return boolean true
    */
   public function _add($item, $saveToDatabase = true) {
      global $xDb;

      if ($this->table && $saveToDatabase) {

         $item = XTools::addslashes($item);
         $xDb->insert($this->table, $item);

      }

      return ($this->list[] = $item);
   }



   /*****************/
   /* MISCELLANEOUS */
   /*****************/

   /**
    * Returns the maximum value of the given attribute
    *
    * @param $attrib The attrib to get the maximum value of (default: xid)
    * @return int Maximum value found or 0
    */
   public function getMaximum($attrib = 'xid') {
      global $xDb;

      $query = "SELECT MAX({$attrib})
                FROM {$this->table}";
      $xDb->setQuery($query);

      return intval($xDb->loadResult());
   }


   /**
    * Returns first occurence of an item by field
    *
    * @deprecated
    * @param $attrib String containing the field name to search in
    * @param $value String containing the string to search for
    * @return mixed The found item or null on failure
    */
   public function getItemByField($attrib, $value) {

      trigger_error(
         "Deprecated XContentList::getItemByField()",
         E_USER_WARNING
      );

      return $this->getItemByAttribute($attrib, $value);
   }


   /**
    * Returns first occurence of an item by field
    *
    * @deprecated
    * @param $attrib String containing the field name to search in
    * @param $value String containing the string to search for
    * @return mixed The found item or null on failure
    */
   public function getItemByAttribute($attrib, $value) {

      trigger_error(
         "Deprecated XContentList::getItemByAttribute()",
         E_USER_WARNING
      );

      foreach ($this->list as $item) {
         if ($item->$attrib == $value) {
            return $item;
         }
      }

      return null;
   }


   /**
    * Returns the amount of items in the list
    *
    * @return Int The amount of items in the list
    */
   public function count() {
      return count($this->list);
   }


   /**
    * Returns list as a JSON Object
    */
   public function encode() {
      return json_encode($this->list);
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