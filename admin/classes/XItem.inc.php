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
    * CONSTRUCTOR
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
      trigger_error("Method 'load()' not overwritten.", E_USER_ERROR);
   }


   /**
    * Loads item information from the database
    *
    * @param $table The table containing the information
    * @param $id The ID of the item in the database
    */
   public function loadFromDatabase($table, $id) {
      global $xDb;

      $query = "SELECT *
                FROM {$table}
                WHERE id = {$id}";
      $xDb->setQuery($query);

      if ($dbRow = $xDb->loadRow()) {

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
      trigger_error("Method 'save()' not overwritten.", E_USER_ERROR);
   }


   /**
    * Saves all changes to the item to the database
    *
    * @param $table The table containing the information
    */
   public function saveToDatabase($table) {
      global $xDb;

      // Prepare variables
      $attribs = array();
      foreach (get_object_vars($this) as $attrib => $value) {

         if ($attrib == 'language' && !array_key_exists($value, Xirt::getLanguages())) {
            return false;
         }

         $value = XTools::addslashes($value);
         $attribs[] = sprintf("%s = '%s'", $attrib, $value);

      }

      // Save changes
      $query = "UPDATE %s SET %s WHERE id = %s";
      $query = sprintf($query, $table, implode(',', $attribs), $this->id);
      $xDb->setQuery($query);
      $xDb->query();

   }


   /**
    * Removes item from the database (placeholder for extending)
    */
   public function remove() {
      trigger_error("Method 'remove()' not overwritten.", E_USER_ERROR);
   }


   /**
    * Removes item from the database
    *
    * @param $table The table containing the information
    */
   public function removeFromDatabase($table) {
      global $xDb;

      $query = "DELETE FROM {$table}
                WHERE id = {$this->id}";
      $xDb->setQuery($query);
      $xDb->query();

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