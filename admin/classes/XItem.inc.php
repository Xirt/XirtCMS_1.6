<?php

/**
 * Class containing details about a XirtCMS item
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package	   XirtCMS
 */
class XItem {

   /**
    * @var The ID of the item
    */
   var $id = 0;


   /**
    * Creates a new XItem with given attributes
    *
    * @param $attribs Property/value combinations for initialization (optional)
    */
   function __construct($attribs = array()) {

      foreach ($attribs as $attrib => $value) {
         $this->set($attrib, $value);
      }

   }


   /**
    * Loads item information from the database (placeholder for extending)
    *
    * @param $id The ID of the item in the database
    */
   public function load($id) {
      trigger_error("[XItem] Method 'load()' not overwritten.", E_USER_ERROR);
   }


   /**
    * Loads item information from the database
    *
    * @param $table The table containing the information
    * @param $id The ID of the item in the database
    */
   public function loadFromDatabase($table, $id) {
      global $xDb;

      // Database query
      $query = 'SELECT * FROM %s WHERE id = :id';
      $query = sprintf($query, $table);

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();

      // Populate instance
      if ($dbRow = $stmt->fetchObject()) {

         foreach ($dbRow as $attrib => $value) {
            $this->set($attrib, $value);
         }

      }

   }



   /**********/
   /* MODIFY */
   /**********/

   /**
    * Sets an attribute for this instance
    *
    * @param $attrib The attribute to set
    * @param $value The value for the given variable
    * @param $unset Used to unset variables (optional, default: false)
    */
   public function set($attrib, $value, $unset = false) {

      $this->$attrib = $value;

      if (isset($unset) && $unset === true) {
         unset($this->$attrib);
      }

   }


   /**
    * Saves changes to the item to the database (placeholder for extending)
    */
   public function save() {
      trigger_error("[XItem] Method 'save()' not overwritten.", E_USER_ERROR);
   }


   /**
    * Saves all changes to the item to the database
    *
    * @param $table The table containing the information
    */
   public function saveToDatabase($table) {
      global $xDb;

      if (!isset($this->id) || !$this->id) {
         return false;
      }

      $xDb->update($table, get_object_vars($this), 'id=' . $this->id);

   }


   /**
    * Removes item from the database (placeholder for extending)
    */
   public function remove() {
      trigger_error("[XItem] Method 'remove()' not overwritten.", E_USER_ERROR);
   }


   /**
    * Removes item from the database
    *
    * @param $table The table containing the information
    */
   public function removeFromDatabase($table) {
      global $xDb;

      if (!isset($this->id) || !$this->id) {
         return false;
      }

      $xDb->delete($table, 'id=' . $this->id);

   }



   /*****************/
   /* MISCELLANEOUS */
   /*****************/

   /**
    * Returns item as a JSON Object
    */
   public function encode() {
      return json_encode($this);
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