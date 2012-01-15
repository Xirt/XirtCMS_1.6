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

      $now = time();

      $query = "REPLACE INTO #__sessions
                VALUES ('{$id}', '{$now}', '{$data}')";
      $xDb->setQuery($query);
      $xDb->execute();

   }


   /**
    * Retrieves session data
    *
    * @param  $id The ID of the current session
    * @return String The serialized data of the current session
    */
   public static function read($id) {
      global $xDb;

      $query = "SELECT data
                FROM #__sessions
                WHERE id = '{$id}'";
      $xDb->setQuery($query);

      return $xDb->loadResult();
   }


   /**
    * Destroys session data
    *
    * @param $id The ID of the current session
    */
   public static function destroy($id) {
      global $xDb;

      $query = "DELETE
                FROM #__sessions
                WHERE id = '{$id}'";
      $xDb->setQuery($query);
      $xDb->execute();

   }


   /**
    * Cleans session table
    *
    * @param $time The maximum session time in seconds
    */
   public static function clean($time) {
      global $xDb;

      $time = time() - $time;

      $query = "DELETE
                FROM #__sessions
                WHERE modified < '{$time}'";
      $xDb->setQuery($query);
      $xDb->execute();

   }

}
?>