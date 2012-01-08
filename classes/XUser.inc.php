<?php

/**
 * Class holding all information of the loaded user
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class XUser {

   /**
    * @var The default rank of a user (defaults to 1)
    */
   var $rank = 1;


   /**
    * CONSTRUCTOR
    *
    * @param $id The ID of the user that should be loaded, defaults null
    */
   function __construct($id = null) {

      if (is_integer($id)) {
         $this->load($id);
      }

   }


   /**
    * Attempts to load given user
    *
    * @param $id Integer with the ID of the user that should be loaded
    * @return boolean Returns true on succes, false on failure
    */
   public function load($id) {
      global $xDb;

      $query = "SELECT *
                FROM #__users
                WHERE id = {$id}";
      $xDb->setQuery($query);

      if ($dbRow = $xDb->loadRow()) {

         foreach ($dbRow as $attrib => $value) {
            $this->$attrib = $value;
         }

         return true;
      }

      return false;
   }


   /**
    * Checks if the user is authenticated for the given range of ranks
    *
    * @param $min The minimum of the range (optional, default to 0)
    * @param $max The maximum of the range (optional, default to 100)
    * @return boolean Returns true when the user is authenticated
    */
   public function isAuth($min = 0, $max = 100) {

      return ($this->rank >= $min && $this->rank <= $max);
   }

}
?>