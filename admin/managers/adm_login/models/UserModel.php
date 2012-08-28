<?php

/**
 * Model for a XirtCMS User
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class UserModel extends XItemModel {

   /**
    * Loads item information from the database
    *
    * @param $username The username of the user
    * @param $email The e-mail address of the user
    */
   public function loadByName($username, $email) {
      global $xCom;

      if (!$this->loadFromDatabaseByName($username, $email)) {
         die($xCom->xLang->messages['noAccountFail']);
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
   public function loadFromDatabaseByName($username, $email) {
      global $xDb;

      // Query
      $query = 'SELECT *                  ' .
               'FROM #__users             ' .
               'WHERE username = :username' .
               '  AND mail = :email       ';

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->bindValue(':username', $username, PDO::PARAM_STR);
      $stmt->bindValue(':email', $email, PDO::PARAM_STR);
      $stmt->execute();

      // Populate instance
      if ($dbRow = $stmt->fetchObject()) {

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

}
?>