<?php

/**
 * List containing simple instances of Translation (XirtCMS menu nodes)
 *
 * @author     A.G. Gideonse
 * @version    1.6
 * @copyright  XirtCMS 2010 - 2012
 * @package    XirtCMS
 */
class TranslationList extends XTranslationList {

   /**
    * @var String with the name of the table containing the information
    */
   protected $_table = '#__menunodes';


   /**
    * Loads list information from the database
    * NOTE: This method is required to call the _new_ method $this->_load();
    *
    * @param $xId Integer with the xId of the items in the list
    * @return boolean True on succes, false on failure
    */
   public function load($xId) {
      return ($this->_table ? !$this->_load($xId) : false);
   }


   /**
    * Loads all content items from the database and adds them to the list
    *
    * @param $xid The xID of the item in the database
    * @access private
    */
   private function _load($xId) {
      global $xDb;

      // Query (selection)
      $query = 'SELECT *                            ' .
               'FROM (%s) AS subset                 ' .
      		   'WHERE xid = :xid ORDER BY preference';

      // Subquery (translations)
      $trans = 'SELECT t1.*, t2.preference         ' .
                'FROM %s AS t1                      ' .
                'INNER JOIN #__languages AS t2      ' .
                'ON t1.language = t2.iso            ' .
                'ORDER BY t2.preference, t1.xid';
      $trans = sprintf($trans, $this->_table);

      // Retrieve data
      $stmt = $xDb->prepare(sprintf($query, $trans));
      $stmt->bindParam(':xid', $xId, PDO::PARAM_INT);
      $stmt->execute();

      // Populate instance
      while ($dbRow = $stmt->fetchObject()) {

         $this->xid = $dbRow->xid;
         $this->menu_id = $dbRow->menu_id;
         $this->parent_id = $dbRow->parent_id;
         $this->_add(new Translation($dbRow), false);

      }

   }



   /***********/
   /*  MODIFY */
   /***********/

   /**
    * Adds an item
    *
    * @param $item The item to add
    * @return boolean true
    */
   public function add($item) {
      $item->set('children', null, true);
      return $this->_add($item);
   }


   /**
    * Sets a new parent for all translations in the list
    *
    * @param $id Integer holding the node ID of the parent item
    */
   public function setParent($id) {
      global $xCom, $xDb;

      if (!$this->count() || $this->parent_id == $id) {
         return false;
      }

      $list = new ContentList($this->menu_id);
      $list->load();

      // Retrieve parent
      $parent = $id ? $list->getItemById($id) : $list;
      $node = $list->getItemById($this->xid);

      // Never allow recursion
      if (!$parent || !$node || $node->getItemById($parent->xid)) {
         return !print($xCom->xLang->messages['invalidParent']);
      }

      // Database query (update old level)
      $query = 'UPDATE %s                    ' .
               'SET ordering = ordering - 1  ' .
               'WHERE parent_id = :parent_id ' .
               '  AND ordering > :ordering   ';
      $query = sprintf($query, $this->_table);

      // Execute query
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':parent_id', $node->parent_id, PDO::PARAM_INT);
      $stmt->bindParam(':ordering', $node->ordering, PDO::PARAM_INT);
      $stmt->execute();

      // Database query (set new parent)
      $query = 'UPDATE %s                     ' .
               'SET parent_id = :parent_id,   ' .
               '    level     = :level + 1,   ' .
               '    ordering  = :ordering + 1 ' .
               'WHERE xid = :xid              ';
      $query = sprintf($query, $this->_table);

      // Execute query
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':parent_id', $parent->xid, PDO::PARAM_INT);
      $stmt->bindValue(':ordering', $parent->getMaxOrdering(), PDO::PARAM_INT);
      $stmt->bindParam(':level', $parent->level, PDO::PARAM_INT);
      $stmt->bindParam(':xid', $this->xid, PDO::PARAM_INT);
      $stmt->execute();

   }


   /**
    * Sets a new ordering value for all translations in the list
    *
    * @param $position Int with the new position in the order
    * @see ContentList::moveUp()
    * @see ContentList::moveDown()
    */
   public function setOrdering($position) {

      foreach ($this->_list as $translation) {

         $translation->set('ordering', $position);
         $translation->save();

      }

   }


   /**
    * Toggles home status of all translations in the list
    */
   public function toggleHome() {

      foreach ($this->_list as $translation) {

         $translation->home = 1;
         $translation->save();

      }

   }


   /**
    * Removes all translations and the children of this node from the database
    */
   public function remove() {
      global $xDb;

      $this->_removeNode($this->xid);

      // Database query (adjust ordering)
      $query = 'UPDATE {$this->table}        ' .
               'SET ordering = ordering - 1  ' .
               'WHERE parent_id = :parent_id ' .
               'AND ordering > :ordering     ';
      $query = sprintf($query, $this->_table);

      // Execute query
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':parent_id', $this->parent_id, PDO::PARAM_INT);
      $stmt->bindParam(':ordering', $this->ordering, PDO::PARAM_INT);
      $stmt->execute();

   }


   /**
    * Removes all translations and the children of this node from the database
    *
    * @access private
    * @param $xId Integer holding the node ID of the node to remove
    */
   private function _removeNode($xId) {
      global $xDb;

      // Database query (retrieve children)
      $query = 'SELECT xid FROM %s WHERE parent_id = :parent_id';
      $query = sprintf($query, $this->_table);

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(':parent_id', $xId, PDO::PARAM_INT);
      $stmt->execute();

      // Remove children
      while ($node = $stmt->fetchObject()) {
         $this->_removeNode($node->xid);
      }

      // Database query (remove)
      $query = 'DELETE FROM %s WHERE xid = :xid';
      $query = sprintf($query, $this->_table);

      // Execute query
      $stmt = $xDb->prepare();
      $stmt->bindParam(':xid', $xId, PDO::PARAM_INT);
      $stmt->execute();

   }

}
?>