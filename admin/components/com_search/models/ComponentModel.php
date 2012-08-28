<?php

/**
 * Controller for the (default) XirtCMS Search Component
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class ComponentModel extends XItemModel {

   /**
    * Loads item information from the database
    */
   public function load($type) {
      $this->loadFromDatabase('#__components', $type);
   }


   /**
    * Loads item information from the database
    *
    * @param $table The table containing the information
    * @param $type The type of the item in the database
    */
   public function loadFromDatabase($table, $type) {
      global $xDb;

      // Database query
      $query = 'SELECT * FROM %s WHERE type = :type';
      $query = sprintf($query, $table);

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':type', $type, PDO::PARAM_STR);
      $stmt->execute();

      // Populate instance
      if ($dbRow = $stmt->fetchObject()) {

         foreach ($dbRow as $attrib => $value) {
            $this->set($attrib, $value);
         }

         $this->config = json_decode($this->config);

      }

   }


   /**
    * Saves changes to the item to the database
    */
   public function save() {

      $this->set('config', json_encode($this->config));
      parent::saveToDatabase('#__components');

   }

}
?>