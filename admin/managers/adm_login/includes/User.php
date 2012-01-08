<?php

/**
 * Object containing details about a XirtCMS user
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2011
 * @package    XirtCMS
 */
class User extends XItem {

   /**
    * Loads item information from the database
    *
    * @param $username The username of the user
    * @param $email The e-mail address of the user
    */
   public function loadByName($username, $email) {
      global $xCom;

      $username = XTools::addslashes($username);
      $email    = XTools::addslashes($email);

   	if (!$this->loadFromDatabaseByName('#__users', $username, $email)) {

         die($xCom->xLang->messages['NoAccountFail']);

      }

   }


   /**
    * Loads item information from the database
    *
    * @param $table The table containing the information
    * @param $username The username  of the item in the database
    * @param $email The e-mail address of the item in the database
    * @return boolean True on success, false on failure
    */
   public function loadFromDatabaseByName($table, $username, $email) {
      global $xDb;

      $query = "SELECT *
                FROM {$table}
                WHERE username = '{$username}'
                   AND mail = '{$email}'";
      $xDb->setQuery($query);

      if ($dbRow = $xDb->loadRow()) {

         foreach ($dbRow as $attrib => $value) {

            $this->set($attrib, $value);

         }

         return true;
      }

      return false;
   }


   /**
    * Saves changes to the item to the database
    */
   public function save() {

      parent::saveToDatabase('#__users');

   }


   /**
    * Removes item from the database
    */
   public function remove() {

      parent::removeFromDatabase('#__users');

   }

}
?>
