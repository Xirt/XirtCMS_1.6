<?php

/**
 * List containing instances of XItem (XirtCMS users)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2011
 * @package    XirtCMS
 */
class UserList extends XContentList {

   /**
    * @var String Table with item information
    */
   var $table = '#__users';


   /**
    * @var String The ordering column of the list (for database loading)
    */
   var $column = 'id';


   /**
    * @var Array The list of columns used for every item
    */
   var $columns = array('id', 'rank', 'name', 'username', 'mail', 'joined');


   /**
    * Adds a user
    *
    * @param $item The item to add
    * @return boolean True of success, false on failure
    */
   public function add($item) {
      global $xCom, $xConf;

      // Already exists
      if ($this->getItemByAttribute('username', $item->username)) {
         return !print($xCom->xLang->messages['nameExists']);
      }

      // Already exists
      if ($this->getItemByAttribute('mail', $item->mail)) {
         return !print($xCom->xLang->messages['mailExists']);
      }

      return parent::_add($item);
   }

}
?>
