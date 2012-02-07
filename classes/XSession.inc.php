<?php

/**
 * Saves sessions in the database instead of the filesystem (configurable)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
Class XSession {

   /**
    * Placeholder
    */
   public static function open() {
   }


   /**
    * Placeholder
    */
   public static function close() {
   }


   /**
    * Saves session data
    *
    * @param $Id The ID of the current session
    * @param $data The serialized data of the current session
    */
   public static function write($id, $data) {
      global $xDb;

      // Database query
      $query = 'REPLACE INTO #__sessions' .
               'VALUES (:id, :now, :data)';

      // Query execution
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':data', $data, PDO::PARAM_STR);
      $stmt->bindParam(':now', time(), PDO::PARAM_INT);
      $stmt->bindParam(':id', $id, PDO::PARAM_STR);
      $stmt->execute();

   }


   /**
    * Retrieves session data
    *
    * @param  $id The ID of the current session
    * @return String The serialized data of the current session
    */
   public static function read($id) {
      global $xDb;

      // Database query
      $query = 'SELECT data                    ' .
               'FROM #__sessions WHERE id = :id';

      // Data retrieval
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':id', $id, PDO::PARAM_STR);
      $stmt->execute();

      return $stmt->fetchColumn();
   }


   /**
    * Destroys session data
    *
    * @param $id The ID of the current session
    */
   public static function destroy($id) {
      global $xDb;

      // Database query
      $query = 'DELETE FROM #__sessions' .
               'WHERE id = :id         ';

      // Query execution
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':id', $id, PDO::PARAM_STR);
      $stmt->execute();

   }


   /**
    * Cleans session table
    *
    * @param $time The maximum session time in seconds
    */
   public static function clean($time) {
      global $xDb;

      // Database query
      $query = 'DELETE FROM #__sessions' .
               'WHERE modified < :time ';

      // Query execution
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':time', time() - $time, PDO::PARAM_INT);
      $stmt->execute();

   }

}
?>