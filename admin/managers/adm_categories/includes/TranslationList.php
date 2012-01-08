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
   var $table = "#__content_categories";


   /**
    * Loads list information from the database
    * NOTE: This method is required to call the _new_ method $this->_load();
    *
    * @param $xId Integer with the xId of the items in the list
    * @return boolean True on succes, false on failure
    */
   public function load($xId) {

      $this->xid = $xId;

      return ($this->table ? !$this->_load($xId) : false);
   }


   /**
    * Loads all content items from the database and adds them to the list
    *
    * @param $xid The xID of the item in the database
    * @access private
    */
   private function _load($xId) {
      global $xDb;

      $query = "SELECT *
                FROM (
                   SELECT t1.*, t2.preference
                   FROM {$this->table} AS t1
                   INNER JOIN #__languages AS t2 ON t1.language = t2.iso
                   ORDER BY t2.preference, t1.xid
                ) AS t3
                WHERE xid = {$xId}
                ORDER BY preference";
      $xDb->setQuery($query);

      foreach ($xDb->loadObjectList() as $dbRow) {

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
      $item->set('config', json_encode($item->config));
      return $this->_add($item);

   }


   /**
    * Sets a new parent for all translations in the list
    *
    * @param $id Integer holding the node ID of the parent item
    */
   public function setParent($id) {
      global $xCom, $xDb;

      if ($this->parent_id == $id || !$this->count()) {                         // Controle kan op child plaatstvinden
         return false;
      }

      $list = new ContentList();
      $list->load();

      $parent = $id ? $list->getItemById($id) : $list;
      $node = $list->getItemById($this->xid);

      // Never allow recursion
      if (!$parent || !$node || $node->getItemById($parent->id)) {
         return !print($xCom->xLang->messages['invalidParent']);
      }

      // Update items at old level
      $query = "UPDATE {$this->table}
                SET ordering = ordering - 1
                WHERE parent_id = {$node->parent_id}
                   AND ordering > {$node->ordering}";
      $xDb->setQuery($query);
      $xDb->query();

      // Set new parent for current items
      $query = "UPDATE {$this->table}
                SET parent_id = {$parent->xid},
                    level     = {$parent->level} + 1,
                    ordering  = {$parent->getMaxOrdering()} + 1
                WHERE xid = {$this->xid}";
      $xDb->setQuery($query);
      $xDb->query();
   }


   /**
    * Sets a new ordering value for all translations in the list
    *
    * @param $position Int with the new position in the order
    * @see ContentList::moveUp()
    * @see ContentList::moveDown()
    */
   public function setOrdering($position) {

      foreach ($this->cList as $translation) {

         $translation->set('ordering', $position);
         $translation->save();

      }

   }


   /**
    * Removes all translations and the children of this node from the database
    */
   public function remove() {
      global $xDb;

      $this->_removeNode($this->xid);

      // Adjust ordering accordingly
      $query = "UPDATE {$this->table}
                SET ordering = ordering - 1
                WHERE parent_id = {$this->parent_id}
                   AND ordering > {$this->ordering}";
      $xDb->setQuery($query);
      $xDb->query();

   }


   /**
    * Removes all translations and the children of this node from the database
    *
    * @access private
    * @param $parent Integer holding the node ID of the node to remove
    */
   private function _removeNode($id) {
       global $xDb;

       $query = "SELECT xid
                 FROM {$this->table}
                 WHERE parent_id = {$id}";
       $xDb->setQuery($query);

       // Remove children
       foreach ($xDb->loadObjectList() as $node) {
          $this->_removeNode($node->xid);
       }

       // Remove node
       $query = "DELETE FROM {$this->table}
                 WHERE xid = {$id}";
       $xDb->setQuery($query);
       $xDb->query();

   }

}
?>